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

![The New Token dialog: a name, what the token may do, and when it expires.](/media/screens/agents-token.webp)

**Access** limits what the token can do: **Full Access**, **Read Only**, or **Content Only**. Give each token no more than it needs. To stop a token working, choose **Revoke** in its menu. Anything using it stops at once.

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
| `GET /api/v1/content/{collection}` | Live entries. Query: `q`, `filter`, `sort`, `fields`, `expand`, `references`, `limit`, `page`, `locale`. See [The content API](#the-content-api). |
| `GET /api/v1/content/{collection}/{slug}` | One live entry. |
| `GET /api/v1/globals/{handle}` | A global's values (only globals with `api: true`). |

Collections with a route are available unless they set `api: false`. Collections without a route are available only with `api: true`. Responses can be cached for a minute, and each visitor can make 120 requests a minute.

## For developers

### Tokens from the command line

```bash
php cms token:create you@example.com --scope='entries/*' --days=90
```

Tokens are shown once and stored hashed. **Scopes** are ability patterns (`entries/*`, `media/import`), `read` for every read-only ability, or `*` for everything you can do. In the admin, **Read Only** is `read`, **Content Only** is `entries/*` and **Full Access** is `*`. A pattern reaches only the abilities named that way: `entries/*` doesn't reach an entry's history, which is `revisions/*`.

### Endpoints

| Method and path | Does |
|---|---|
| `GET /api/v1` | Describes the API. |
| `GET /api/v1/abilities` | The abilities this token may run, with their input and output schemas. |
| `GET /api/v1/openapi.json` | The API as an OpenAPI 3.1 document, for tools that generate a client. Without a token it says how the API works (the paths in this table, the error shape, bearer authentication and the public content API) and names no ability. With a token it has a path for every ability that token may run, each with its input and output schema. |
| `GET /api/v1/abilities/{name}` | Runs a read-only ability with query parameters. |
| `POST /api/v1/abilities/{name}` | Runs any ability with a JSON body. |
| `POST /api/v1/batch` | Runs up to 25 abilities: `{ "calls": [{ "ability": "…", "input": {} }], "stopOnError": true }`. |

### OpenAPI

`GET /api/v1/openapi.json` is the API as an OpenAPI 3.1 document, for tools that generate a client or want to know every call before making one. What it holds depends on who asks:

| Asked | It has |
|---|---|
| Without a token | How the API works: `/abilities`, `/abilities/{name}` and `/batch`, the error shape, bearer authentication, and the public content API (`/content/{collection}`, `/content/{collection}/{slug}`) with its query parameters and answers. It names no ability, so it doesn't say which plugins a site runs |
| With a token | A path for every ability that token may run, plugins' included: `/abilities/entries/list` with `get` and `post`, each with its input and output schema |

```bash
curl https://your-site.com/api/v1/openapi.json -H "Authorization: Bearer cms_…"
```

`GET /api/v1` links to it, under `endpoints.openapi`.

### Query parameters

A read ability called with `GET` reads its query string as its schema asks: `?perPage=5` is a number, `?force=true` a boolean and `?ids[]=a&ids[]=b` a list. A map, or a list of maps, is one value, as JSON. A number too large to be one is refused as invalid input.

### The content API

`GET /api/v1/content/{collection}` answers with the collection's live entries: published, their time come and their end date not passed.

```bash
curl -g "https://your-site.com/api/v1/content/events?fields=title,uri,level&sort=-level,title"
```

```json
{
  "data": [
    { "id": "01m75fmerrprznv7tkcgs8v0xk", "title": "Type night", "uri": "/events/type-night", "data": { "level": 2 } },
    { "id": "01m75fmf4fypd21ehhd1bh0h7t", "title": "Stream night", "uri": "/events/stream-night" }
  ],
  "meta": { "total": 2, "page": 1, "perPage": 10, "pages": 1, "count": 2, "from": 1, "to": 2, "hasMore": false },
  "links": { "self": "https://your-site.com/api/v1/content/events?fields=title%2Curi%2Clevel&sort=-level%2Ctitle&page=1", "first": "…", "prev": null, "next": null, "last": "…" }
}
```

Without `fields`, an entry has `id`, `collection`, `locale`, `title`, `slug`, `uri`, `data` (its field values), `parentId`, `publishedAt` and `updatedAt`.

| Query | Does |
|---|---|
| `q` | Searches the entries |
| `filter[field]=value` | Entries whose field is that value. On a relation or terms field the value is an id or a slug: `filter[topics]=news` |
| `filter[field][op]=value` | With an operator: `eq`, `ne`, `lt`, `lte`, `gt`, `gte`, `in` (`a,b`), `contains` (a list has the value, a text has it in it) and `exists` (`true` or `false`) |
| `sort` | One or several fields, `-` for descending: `sort=-publishedAt,title` |
| `fields` | Only these of each entry, beside its `id`: `fields=title,uri,summary` |
| `expand` | Gives relations as entries instead of ids: `expand=author,related.author`. A relation in a group is `expand=meta.related` |
| `references` | Only entries that name this entry id; `references_field` looks in one field |
| `limit`, `page` | The page size, up to 200, and the page. The default size is the collection's |
| `locale` | The language; the default language without it |

A filter or a sort names a field of the collection, something inside one (`filter[place.address][contains]=Gent`), or one of `id`, `title`, `slug`, `uri`, `parentId`, `publishedAt`, `updatedAt` and `position`. Numbers and switches compare as what they are. A field that is missing or empty equals only nothing (`filter[summary]=`), is unequal to every value, and is neither less nor more than any, on every driver and database.

`expand` goes two levels deep at most, and gives only published entries the request may read, of collections the API serves: drafts, expired entries and what is for signed-in visitors stay out of expanded relations as they stay out of the list. A level costs one lookup whatever the page holds, and one answer expands at most 200 entries.

`GET /api/v1/content/{collection}/{slug}` answers with one entry under `data`, and takes `fields`, `expand` and `locale`.

The API refuses what it does not know with `422 invalid_input`, instead of answering as if it had not been asked:

| Asked | Answer |
|---|---|
| `?filter[status]=draft` | `“status” is not a field of events.` Columns that are not public, such as `status` or `author_id`, are not fields |
| `?filter[level][between]=1` | `Unknown filter on level. Use one of: eq, ne, lt, lte, gt, gte, in, contains, exists.` |
| `?fields=nope` | `“nope” is not a field of events.` |
| `?expand=host.author.x` | `“author.x” is not a relation of what “host” names; relations are expanded at most 2 levels deep.` |
| `?page=9` | `There is no page 9: the last one is 1.` |

`contains` on a field that is neither a list nor a text, and a `page` or `limit` that is no number in range, are refused the same way. The parameters and answers are all in [`openapi.json`](#openapi).

### Responses and limits

Successful calls return `{ "data": … }`. An ability that changes something takes `"dryRun": true`: nothing is written, and `data` is `{ dryRun, ability, checked, input, changes }`, where `checked` is `"full"` when the call was refused exactly where the real one would be and `changes` lists what would change or be removed, and `"input"` when only the input and your permission were checked. Errors return `{ "error": { "type", "message", "details" } }` with status 422, 403, 401, 404, 409 or 500. A token asked for something outside its scopes gets `403`: `{"error": {"type": "forbidden", "message": "This token is not scoped for entries/delete."}}`. Each token can make 240 requests a minute.
