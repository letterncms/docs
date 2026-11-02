---
id: 01m5wn8r98t8evwhskerf4er3d
title: REST API
position: 3
description: Connect your site to other apps and scripts over HTTP, or read your published content for a headless front end.
---
The REST API lets other software work with your site over HTTP: an integration that adds products, a script that imports posts, a front end built in another framework. It runs the same [abilities](/agents/abilities) as the admin, with the same permissions and the same audit log.

There are two parts. The **ability API** can do anything you can, with a token. The **content API** reads published content, with no token at all.

## Create a token

A token is a password for one app or script. It acts as you, so keep it secret.

1. Click your name at the bottom of the sidebar and choose **Account**.
2. Under **API Tokens**, press **New Token**.
3. Name it after what will use it, choose its **Access** and when it **Expires**, then press **Create Token**.
4. Copy the token. It's shown only once.

![The New API Token dialog: a name, what the token may do, and when it expires.](/media/screens/agents-token.webp)

**Access** limits what the token can do: **Everything you can do**, **Read Only**, or **Content Only**. Give each token no more than it needs. To stop a token working, press **Revoke** next to it. Anything using it stops at once.

## Make a request

Send the token as a bearer token. This lists the entries of the `posts` collection:

```bash
curl https://your-site.com/api/v1/abilities/entries/list \
  -H "Authorization: Bearer cms_…" -G -d collection=posts
```

Read-only abilities answer `GET` with query parameters. Every ability answers `POST` with a JSON body:

```bash
curl https://your-site.com/api/v1/abilities/entries/create \
  -H "Authorization: Bearer cms_…" -H "Content-Type: application/json" \
  -d '{"collection": "posts", "title": "Hello"}'
```

Every ability on your site, with what it takes, is in the [abilities reference](/reference/abilities).

## Read published content

For a headless front end, published content is readable without a token:

| Path | Returns |
|---|---|
| `GET /api/v1/content/{collection}` | Live entries. Query: `q`, `filter[field]=value`, `sort`, `limit`, `page`, `locale`. |
| `GET /api/v1/content/{collection}/{slug}` | One live entry. |
| `GET /api/v1/globals/{handle}` | A global set's values (only sets with `api: true`). |

Collections with a route are available unless they set `api: false`. Collections without a route are available only with `api: true`. Responses can be cached for a minute, and each visitor can make 120 requests a minute.

## For developers

### Tokens from the command line

```bash
php cms token:create you@example.com --scope='entries/*' --days=90
```

Tokens are shown once and stored hashed. **Scopes** are ability patterns (`entries/*`, `media/import`), `read` for every read-only ability, or `*` for everything you can do. In the admin, **Read Only** is `read`, **Content Only** is `entries/*` and **Everything you can do** is `*`.

### Endpoints

| Method and path | Does |
|---|---|
| `GET /api/v1` | Describes the API. |
| `GET /api/v1/abilities` | The abilities this token may run, with their input schemas. |
| `GET /api/v1/abilities/{name}` | Runs a read-only ability with query parameters. |
| `POST /api/v1/abilities/{name}` | Runs any ability with a JSON body. |
| `POST /api/v1/batch` | Runs up to 25 abilities: `{ "calls": [{ "ability": "…", "input": {} }], "stopOnError": true }`. |

### Responses and limits

Successful calls return `{ "data": … }`. Errors return `{ "error": { "type", "message", "details" } }` with status 422, 403, 401, 404, 409 or 500. Each token can make 240 requests a minute.
