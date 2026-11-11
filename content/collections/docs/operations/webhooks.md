---
id: 01m75g1ybhq6hr872x9nheg68p
title: Webhooks
position: 11
description: 'Tell other services what happens on your site: a signed request when an entry is published, a file is uploaded or the site is built.'
---
A webhook tells another service that something happened on your site. When an entry is published, a file is uploaded, an account changes or the site is published, each address that asked for that event gets a signed JSON request. Use it to refresh a search index, rebuild a front end, or post to a chat.

Webhooks is a free plugin: install it from **Plugins → Store**, or with `composer require letterncms/webhooks`.

## Add a webhook

1. Open **Settings → Webhooks** and press **New Webhook**.
2. Enter the **Address**, an `https://` address on the public internet, and a **Name** if you like.
3. Copy the **signing secret**. It is shown this once.
4. On the webhook's **Settings** tab, choose the events it listens for.

Press **Send Test** on its page to send a test event.

## See what was sent

A webhook's **Deliveries** tab is its log: every attempt, its status (**Waiting**, **Delivered** or **Failed**) and the receiver's answer. **Send Again** redelivers one.

A delivery that fails is tried again after 1 minute, 5 minutes, 30 minutes, 2 hours and 12 hours. The **Webhooks** widget on the home screen says when deliveries failed or are being tried again, and is empty while all is well.

On the **Settings** tab, **Send Deliveries** turns a webhook off without deleting it, **New Signing Secret** replaces the secret (the old one stops working), and **Delete** removes the webhook with its log.

## Events

| Event | Sent when |
|---|---|
| `entry.saved`, `entry.published`, `entry.unpublished`, `entry.deleted` | An entry is saved, goes live, goes offline or is deleted |
| `media.uploaded`, `media.updated`, `media.deleted` | A file is added, changed or removed |
| `account.created`, `account.verified`, `account.updated`, `account.email-changed`, `account.password-changed`, `account.granted`, `account.revoked`, `account.deleted` | A [visitor's account](/operations/public-accounts) changes |
| `site.built` | The site was published |

## For developers

### What a receiver gets

```http
POST /hook
Content-Type: application/json
X-Cms-Event: entry.published
X-Cms-Delivery: 01m747ke1wwg8r90d75x3j21s5
X-Cms-Attempt: 1
X-Cms-Signature: t=1794364782,v1=4244dd87…

{"id":"01m747ke1wwg8r90d75x3j21s5","event":"entry.published","createdAt":"2026-11-11T02:39:42+00:00","site":"https://example.com","data":{"entry":{"id":"…","collection":"pages","locale":"en","slug":"opening-hours","title":"Opening hours","status":"published","uri":"/opening-hours","url":"https://example.com/opening-hours","publishedAt":"…","updatedAt":"…"}}}
```

A payload says what changed and where to find it, not the content: `data.entry`, `data.media` or `data.account` (id, email, name), who did it in `data.by`, and for `site.built` when it was built and how many pages. Read the content with the [REST API](/agents/rest-api).

Answer with any `2xx` within eight seconds. Anything else is tried again on the schedule above; `410 Gone` ends it at once. A redelivery keeps the payload's `id`, so a receiver can tell it has seen it.

### Verify the signature

`X-Cms-Signature` is `t=<unix time>,v1=<hex>`. `v1` is the HMAC-SHA256, in hex, of `<t>.<body>` with the webhook's signing secret. Compute it over the body exactly as received, compare in constant time, and refuse a `t` more than five minutes old:

```php
$body = file_get_contents('php://input');
$secret = getenv('CMS_WEBHOOK_SECRET');

[$t, $v1] = sscanf($_SERVER['HTTP_X_CMS_SIGNATURE'] ?? '', 't=%d,v1=%s');
$ok = abs(time() - $t) <= 300 && hash_equals(hash_hmac('sha256', $t.'.'.$body, $secret), (string) $v1);

if (! $ok) {
    http_response_code(401);
    exit;
}

$event = json_decode($body, true);
```

The same in Node.js:

```javascript
import { createHmac, timingSafeEqual } from 'node:crypto'

export function verify(body, header, secret) {
  const match = /^t=(\d+),v1=([0-9a-f]{64})$/.exec(header ?? '')
  if (!match || Math.abs(Date.now() / 1000 - Number(match[1])) > 300) return false
  const expected = createHmac('sha256', secret).update(`${match[1]}.${body}`).digest('hex')
  return timingSafeEqual(Buffer.from(expected), Buffer.from(match[2]))
}
```

`body` is the raw request body, as a string or a buffer: parse the JSON only after it verifies.

### Where deliveries go

A webhook goes only to an `https://` address on the public internet, on port 443, 80, 8080 or 8443. The host is resolved when a delivery is sent, every address it resolves to has to be public, the connection is checked against that address, and redirects and proxies are not followed. Anything else is refused when the webhook is saved:

```json
{ "error": { "type": "invalid_input", "message": "A webhook goes to an https:// address.", "details": { "url": "A webhook goes to an https:// address." } } }
```

For local development, `CMS_STORE_ALLOW_PRIVATE=true` in `.env` lets everything the CMS fetches, webhooks included, go to `http://` and to private addresses such as `localhost`. It only works when `APP_ENV` is `local` or `testing`.

### Without a worker

No queue worker is needed. On PHP-FPM and LiteSpeed, deliveries go out right after the response of the request that caused them. On other servers, or on a site with few visits, send deliveries and retries on time from cron:

```bash
* * * * * php /path/to/site/cms webhooks:deliver
```

### Where it is kept

| Kept in | What |
|---|---|
| `config/webhooks.yaml` | The addresses, their names and events, and whether each is on |
| `storage/secrets.json` | Each signing secret, encrypted with the site's other secrets. No listing or page shows one again |

### Abilities

All need the `webhooks.manage` permission (**Manage Webhooks**), which administrators have.

| Ability | Does |
|---|---|
| `webhooks/list`, `webhooks/get` | The webhooks, with their events and last delivery |
| `webhooks/create` | Adds one: `url`, and `name` and `events` if you like. Answers with its signing secret, this once |
| `webhooks/update` | Changes its address, name, events or whether it is on |
| `webhooks/renew-key` | Makes a new signing secret and answers with it, this once |
| `webhooks/delete` | Removes a webhook, its secret and its delivery log |
| `webhooks/test` | Sends a `webhook.test` event to one webhook |
| `webhook-deliveries/list`, `webhook-deliveries/get` | The delivery log, of one webhook or all, by `status`; one delivery with its payload and the start of the answer |
| `webhook-deliveries/create` | Sends a delivery again: `from` is its id |

Through an ability a webhook can also listen for a group (`entry.*`) or for everything (`*`). Everything that changes something takes `dryRun: true`:

```bash
php cms run webhooks/create --dry-run --input='{"url":"https://example.com/hook","name":"Search index","events":["entry.published","entry.unpublished","entry.deleted"]}'
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "webhooks/create",
        "checked": "full",
        "input": { "url": "https://example.com/hook", "name": "Search index", "events": ["entry.published", "entry.unpublished", "entry.deleted"], "enabled": true },
        "changes": [
            { "action": "create", "type": "webhook", "name": "Search index", "url": "https://example.com/hook", "events": ["entry.published", "entry.unpublished", "entry.deleted"], "enabled": true }
        ]
    }
}
```

Agents read the list of events from `cms://webhooks/events`.

### From another plugin

The plugin listens for the [hooks](/plugins/hooks) named after its events and adds none of its own. To send your own deliveries, call `Cms\Webhooks\Dispatcher::queueFor($webhookId, $event, $data)`.

A form can also post each submission to an address of its own: see [Forms](/editing/forms).
