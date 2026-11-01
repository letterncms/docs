---
id: 01m5wn8r98t8evwhskerf4er3d
title: REST API
position: 2
group: 'API'
description: Run any ability over HTTP with a token, or read published content without one.
---
## Authentication

Create a personal access token under **Account → Tokens** (or `php cms token:create you@example.com --scope='entries/*'`) and send it as a bearer token:

```bash
curl https://your-site.com/api/v1/abilities/entries/list \
  -H "Authorization: Bearer cms_…" -G -d collection=posts
```

Tokens are shown once and stored hashed. **Scopes** limit what a token can do: ability patterns (`entries/*`, `media/import`), `read` for every read-only ability, or `*` for everything you can do.

## Endpoints

| Method and path | Does |
|---|---|
| `GET /api/v1` | Describes the API. |
| `GET /api/v1/abilities` | Abilities this token may run, with input schemas. |
| `GET /api/v1/abilities/{name}` | Run a read-only ability with query parameters. |
| `POST /api/v1/abilities/{name}` | Run any ability with a JSON body. |
| `POST /api/v1/batch` | Run up to 25 abilities: `{ "calls": [{ "ability": "…", "input": {} }], "stopOnError": true }`. |

Successful calls return `{ "data": … }`; errors return `{ "error": { "type", "message", "details" } }` with status 422, 403, 401, 404, 409 or 500. Requests are limited to 240 a minute per token.

## Content delivery API

For headless front ends, published content is readable without a token:

| Path | Returns |
|---|---|
| `GET /api/v1/content/{collection}` | Live entries. Query: `q`, `filter[field]=value`, `sort`, `limit`, `page`, `locale`. |
| `GET /api/v1/content/{collection}/{slug}` | One live entry. |
| `GET /api/v1/globals/{handle}` | A global set's values (only sets with `api: true`). |

Collections with a route are available unless they set `api: false`; collections without a route only with `api: true`. Responses are cacheable for a minute, and limited to 120 requests a minute per visitor.
