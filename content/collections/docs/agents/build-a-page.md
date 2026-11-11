---
id: 01m75ffqennk25rqa94ayt33k1
title: Build a page with an agent
position: 5
description: 'What an agent does to put a page on your site, call by call: read the site, check the page, create it, publish it.'
---
When you ask an AI tool for a page, it doesn't guess its way in. It reads what your site is made of, checks its work before anything is written, and only then creates and publishes. This page follows those calls one by one, so you know what happens on your site, and so you can do the same from a script.

The calls are shown with the [command line](/agents/cli), because they are easy to try there. Over [MCP](/agents/mcp) an agent makes the same calls as tools (`entries.create` for `entries/create`), and over the [REST API](/agents/rest-api) as `POST /api/v1/abilities/entries/create`. The answers are the same on all three.

## 1. Read the site

An agent starts with what exists, so the page uses your collections, your design and your components instead of inventing its own.

| It reads | To learn |
|---|---|
| `cms://collections`, or `collections/list` | Which collections there are and what fields they have |
| `cms://site/design`, or `design/get` | The tokens, fonts and element styles to build with |
| `cms://blocks`, or `blocks/types` | Every block, how blocks nest, and worked examples |
| `components/list`, `templates/list` | The components and templates to reuse |

```bash
php cms run components/list
```

On a new site that answers with the header and the footer.

## 2. Read the collection's schema

`collections/schema` says exactly what an entry of one collection must look like: a JSON Schema for its `data`, as a draft and to be published, and the whole input of `entries/create` and `entries/update` for that collection.

```bash
php cms run collections/schema handle=pages
```

```json
{
    "data": {
        "handle": "pages",
        "title": "Pages",
        "data": {
            "type": "object",
            "properties": {
                "content": {
                    "title": "Content",
                    "type": "array",
                    "description": "Content. A list of blocks: {type, props, style?, children?}. See blocks/types for the catalog and cms://blocks for examples.",
                    "items": { "type": "object", "properties": { "…": {} }, "required": ["type"] }
                },
                "template": {
                    "title": "Template",
                    "type": ["string", "null"],
                    "enum": ["default", "page", "post", null],
                    "description": "Template"
                }
            }
        },
        "draft": { "…": {} },
        "create": { "…": {} },
        "update": { "…": {} }
    }
}
```

`data` is what a published entry must follow, `draft` what a draft may be, which is looser where a field is only required to publish. Over MCP the same schema is the resource `cms://collections/pages/schema`.

## 3. Check the page before creating it

A blocks field takes blocks as JSON or as [Block Markdown](/reference/block-markdown). With `--dry-run` (`dryRun: true` over MCP and the API) the call is checked and nothing is written:

```bash
php cms run entries/create --dry-run collection=pages title=Pricing \
  'data={"content":"::: section\n## Pricing\n\nOne plan, everything in it.\n\n:::: buttons\n::::: button {\"props\":{\"label\":\"Start\",\"url\":\"/about\",\"variant\":\"primary\"}}\n:::::\n::::\n:::"}'
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "entries/create",
        "checked": "full",
        "input": {
            "collection": "pages",
            "title": "Pricing",
            "data": {
                "content": "::: section\n## Pricing\n\nOne plan, everything in it.\n\n:::: buttons\n…"
            },
            "status": "draft"
        },
        "changes": [
            {
                "action": "create",
                "type": "entry",
                "collection": "pages",
                "title": "Pricing",
                "slug": "pricing",
                "locale": "en",
                "status": "draft",
                "uri": "/pricing"
            }
        ]
    }
}
```

`"checked": "full"` means the real call would be refused exactly where this one would be. It says what would happen: a draft, at `/pricing`.

A mistake comes back the same way it would from the real call, with the field named by its path in the input, so the agent can fix it and try again:

```bash
php cms run entries/create --dry-run collection=pages title=Pricing 'data={"template":"landing"}'
```

```json
{
    "error": {
        "type": "invalid_input",
        "message": "Invalid input: data.template: Must be one of: \"default\", \"page\", \"post\", null.",
        "details": {
            "data.template": "Must be one of: \"default\", \"page\", \"post\", null."
        }
    }
}
```

## 4. Create it

The same call without `--dry-run` makes the entry, as a draft. The answer is the entry: its `id`, its `uri`, its `status` and its `data`, with the Block Markdown now stored as blocks.

```json
{
    "data": {
        "id": "01m75fcmrc1r865pt5ww1k62v4",
        "collection": "pages",
        "title": "Pricing",
        "slug": "pricing",
        "uri": "/pricing",
        "status": "draft",
        "data": {
            "content": [
                { "id": "mc05ec6ffb2", "type": "section", "props": [], "children": [
                    { "id": "m70141b0f04", "type": "heading", "props": { "text": "Pricing", "level": "2" } },
                    { "id": "m50281be3eb", "type": "paragraph", "props": { "text": "One plan, everything in it." } },
                    { "id": "m926798545c", "type": "buttons", "props": [], "children": [
                        { "id": "mba18c49926", "type": "button", "props": { "label": "Start", "url": "/about", "variant": "primary" } }
                    ] }
                ] }
            ],
            "template": null
        },
        "…": "…"
    }
}
```

Nothing is on the site yet. You can open the draft in the admin, and the agent can keep changing it with `entries/update`, whose `data` is merged into what is there.

## 5. Publish it

Publishing can be checked first too:

```bash
php cms run entries/publish id=01m75fcmrc1r865pt5ww1k62v4 --dry-run
```

```json
{
    "data": {
        "dryRun": true,
        "ability": "entries/publish",
        "checked": "full",
        "input": { "id": "01m75fcmrc1r865pt5ww1k62v4" },
        "changes": [
            {
                "action": "publish",
                "type": "entry",
                "id": "01m75fcmrc1r865pt5ww1k62v4",
                "collection": "pages",
                "title": "Pricing",
                "at": "2026-11-11T14:15:03+00:00",
                "expiresAt": null,
                "uri": "/pricing"
            }
        ]
    }
}
```

Then for real:

```bash
php cms run entries/publish id=01m75fcmrc1r865pt5ww1k62v4
```

The entry comes back with `"status": "published"`, and the site rebuilds the pages the change touches. `site/build-status` says when it is done:

```json
{
    "data": {
        "state": "done",
        "progress": 1,
        "message": "Updated “Pricing”",
        "pending": 0,
        "finishedAt": "2026-11-11T14:15:05+00:00",
        "pages": 7,
        "errors": [],
        "warnings": [],
        "enabled": true
    }
}
```

The page is live at `/pricing`.

## 6. Change it later

`entries/update` on a published entry doesn't change the site. It saves a draft beside the live page: the entry then says `"displayStatus": "changed"` and `"hasDraft": true`. `entries/publish` puts the draft live, and `entries/discard-draft` throws it away. Pass `publish: true` to `entries/update` to do both in one call.

## What keeps this safe

- **Permissions.** Each call runs as the person behind the agent, or with a token's scopes. A read-only token is refused: `"This token is not scoped for entries/delete."`
- **Drafts first.** Creating and updating make drafts. Only publishing changes the site.
- **Dry runs.** An agent can check any change, and a destructive one always. The [assistant](/agents/assistant) and well-behaved tools ask you before deleting.
- **The audit log.** Every change is recorded with who made it and how: `cli`, `mcp`, `rest` or the admin.

See [Abilities](/agents/abilities#dry-runs) for what a dry run checks, and the [abilities reference](/reference/abilities) for every call your site has.
