---
id: 01m5wn8r8zc4z78k38e6gb1fpk
title: Command line
position: 4
description: Run abilities, build the site, and manage users, tokens and plugins from the terminal or a deploy script.
---
Lettern has a command line for developers and deploy scripts: run any ability, build the site, manage users and plugins. Run `php cms` from your site's folder to see the commands, plugins' included.

```bash
php cms run entries/create collection=pages title=About
```

## Run abilities

| Command | Does |
|---|---|
| `cms run` | Lists the abilities. `cms run --list --json` gives them with their input and output schemas. |
| `cms run <ability> key=value …` | Runs an ability. Values may be JSON: `cms run entries/create collection=pages title=About 'data={"summary":"Hi"}'`. Pass the whole input with `--input='{…}'` instead. |
| `cms run <ability> … --dry-run` | Checks only: the input is validated and you are authorized as usual, nothing is written, and the answer says what would change. |

Abilities run from the command line act with full rights, and show as `cli` in the audit log. Add `--as=you@example.com` to run one as that user, with their permissions. An ability can opt out of the command line with `expose: ['cli' => false]`.

`cms run` prints one JSON document: `{"data": …}` when it worked, and `{"error": {"type", "message", "details"}}` with a non-zero exit when it didn't, the same shape the [REST API](/agents/rest-api) answers with.

```bash
php cms run entries/delete id=01jx… --dry-run
```

```json
{"data": {"dryRun": true, "ability": "entries/delete", "checked": "full", "input": {"id": "01jx…"}, "changes": [{"action": "delete", "type": "entry", "id": "01jx…", "title": "About", "uri": "/about", …}]}}
```

## JSON from every command

Every command takes `--json`. It then prints one JSON document and nothing else, `{"data": …}` or `{"error": {…}}` with a non-zero exit, and never asks a question: `pull`, `push` and `sync:undo` need `--yes` with it. An unknown command, or a site that can't start, answers the same way.

```bash
php cms build --json
```

```json
{
    "data": {
        "pages": 7,
        "seconds": 0.2,
        "errors": [],
        "warnings": []
    }
}
```

```bash
php cms vendor remove nothing --json
```

```json
{
    "error": {
        "type": "invalid_input",
        "message": "Nothing is imported as “nothing”."
    }
}
```

`type` is one of `invalid_input`, `forbidden`, `unauthenticated`, `not_found`, `conflict` and `failed`. `details`, when it is there, names what was wrong by its path in the input. Something unexpected is logged and said as "The command failed.", not as its internals.

## Build and check the site

| Command | Does |
|---|---|
| `cms serve --port=8000` | Starts a development server. |
| `cms build` | Builds the whole static site. `--strict` fails on warnings, such as a missing image. |
| `cms links:check` | Fails on links, images and anchors in the built site that lead nowhere. External links are left alone. |
| `cms schemas` | Writes the [JSON Schema files](/agents#the-content-model-as-json-schema-files) of the content model to `content/schemas/`. The site keeps them current itself; `--check` writes nothing and fails when they are not. |
| `cms media:check` | Imports `content/media` and reports what's broken: see [Media](/content/media). `--strict`, `--adopt`. |
| `cms publish:scheduled` | Lets scheduled entries go live. Run it from cron every minute. |

## Set up and maintain

| Command | Does |
|---|---|
| `cms install` | Installs a site: see [Installation](/getting-started/installation). `--kit=<handle>` starts it from a site kit (`minimal` unless you say otherwise, `none` for an empty site). |
| `cms migrate` | Runs migrations and plugin install and upgrade steps, and imports `content/media`. It never asks before it runs. `migrate:status`, `migrate:rollback` and the other `migrate:` commands cover the core's tables and the plugins'. |
| `cms update` | Checks the signed update list and [updates the core](/getting-started/upgrading). `--check` only says what's on offer. `--security-only` does what an admin's visit would, for cron. |
| `cms kit:list` | Lists the site kits this site can apply: `minimal`, which comes with the CMS, and the folders in `kits/`. |
| `cms kit:apply <handle>` | Copies a site kit into this site. `--mode=design` brings its design only, `full` (the default) its content too. `--dry-run` lists every step; while the site has something of a name the kit brings, it refuses until `--clash=skip`, `replace` (after a snapshot in `storage/backups/`) or `rename`. `kit:apply minimal --clash=replace` puts the kit a new site starts from back. |
| `cms kit:export <folder>` | Writes this site as a site kit: content, design and the media they name, never accounts, secrets or settings of this server. |

## Users, tokens and plugins

| Command | Does |
|---|---|
| `cms user:create --email= --name= --role=` | Creates a user. `--super` makes a super administrator. |
| `cms token:create <email> --scope=… --days=` | Creates an API token for the [REST API](/agents/rest-api) or [MCP](/agents/mcp). |
| `cms plugins` | Lists plugins and modules with their status. |
| `cms plugin enable\|disable\|uninstall <name>` | Manages a plugin. `--delete-files` removes it from disk on uninstall. |
| `cms license:status`, `license:set <key>`, `license:refresh`, `license:clear` | Reads or changes the [license](/reference/license#paid-plugins) of a paid plugin. They don't show in `cms list`. |
