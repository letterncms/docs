---
id: 01m5wnc9y2yajdbdkwgmtxz24s
title: Email
position: 5
description: Connect a mail service so invitations, password resets and form notifications reach people's inboxes.
---
Lettern sends email for invitations, password resets, and form notifications. A new site only writes emails to a log, so nothing goes out by accident while you build. Connect a real mail service before launch.

## Set up email

1. Open **Settings → Email**.
2. Under **Send With**, choose how mail goes out. Each choice asks for its own details.
3. Fill in the **From Address** and **From Name** people will see.
4. Add an **Email Footer** if you like, such as your address. It's shown under every email.

| Send With | For |
|---|---|
| **SMTP** | Any mail server or provider that gives you SMTP details: a host, a port, a username and a password. |
| **Brevo** | Brevo's email service, with an API key. Install the free Brevo plugin first, from **Plugins**. It also takes [newsletter signups](/operations/newsletter). |
| **Server mail (sendmail)** | The hosting server's own mail, with nothing to fill in. Only offered where the host lets PHP run it: many shared hosts don't, and then SMTP is the way. |
| **Log only (development)** | Nothing is sent: messages are written to the log. The default. |

Emails wear your site's colors: the background, text and buttons come from your [design system](/design/design-system).

## Check that it works

Press **Send Test Email** at the top of **Settings → Email** or on the **Email** card on the dashboard, or press `⌘K` and choose it there. It goes to the address you sign in with, with the settings as saved.

The **Email** card on the dashboard shows how mail is sent, how many emails went out or failed in the last 7 days, and the latest ones. It says **Not delivering** while you're still on **Log only**.

::: callout {"props":{"tone":"tip","text":"With Brevo, your sender domain must be verified in Brevo first. Find the API key in Brevo under <strong>SMTP &amp; API → API keys</strong>. A <strong>Brevo</strong> card on the dashboard then shows deliveries, opens, clicks and bounces for the week."}}
:::

## For developers

### Passwords and keys

Passwords and API keys entered in the settings are stored encrypted in `storage/`, not in `config/email.yaml`. On servers you can set them as environment variables instead: `CMS_EMAIL_SMTP_PASSWORD`, `CMS_EMAIL_BREVO_API_KEY`.

The `email/test`, `email/status` and `email/log` abilities send a test, report the transport and counts, and list recent emails. They need `settings.manage`.

### Colors

Mail takes its background, text and button colors from the design system through the `email.colors` filter. A plugin can change them there.

### Send email from a plugin

Email is part of Lettern, so every plugin can send. `Body::render()` writes paragraphs and an optional button in the site's colors; the mailer adds the layout, sends it with the chosen transport and logs it:

```php
use Cms\Modules\Email\Body;
use Cms\Modules\Email\Mailer;
use Cms\Modules\Email\Message;

$body = Body::render(['Your review is live.'], ['View it', $url]);

app(Mailer::class)->send(new Message($user->email, 'Your review is live', $body['html'], $body['text']));
```

`send()` never throws: a failure is logged, so a form or an invitation never breaks on mail problems.

### Add another provider

A provider plugin registers a transport with its settings fields. The Brevo plugin is a few lines and a good template:

```php
$this->cms()->whenAvailable(\Cms\Modules\Email\Transports::class, function ($transports) {
    $transports->register('postmark', 'Postmark', [
        ['handle' => 'postmark_token', 'type' => 'text', 'label' => 'Server token', 'secret' => true],
    ], fn (array $settings) => new PostmarkTransport($settings['postmark_token'] ?? ''));
});
```

Fields marked `secret` are stored encrypted, and the transport appears under **Send With**.
