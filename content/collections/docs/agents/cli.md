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
| `cms run` | Lists the abilities. |
| `cms run <ability> key=value …` | Runs an ability. Values may be JSON: `cms run entries/create collection=pages title=About 'data={"summary":"Hi"}'`. Pass the whole input with `--json='{…}'` instead. |

Abilities run from the command line act with full rights, and show as `cli` in the audit log. Add `--as=you@example.com` to run one as that user, with their permissions. An ability can opt out of the command line with `expose: ['cli' => false]`.

## Build and check the site

| Command | Does |
|---|---|
| `cms serve --port=8000` | Starts a development server. |
| `cms build` | Builds the whole static site. `--strict` fails on warnings, such as a missing image. |
| `cms links:check` | Fails on links, images and anchors in the built site that lead nowhere. External links are left alone. |
| `cms media:check` | Imports `content/media` and reports what's broken: see [Media](/content/media). `--strict`, `--json`, `--adopt`. |
| `cms publish:scheduled` | Lets scheduled entries go live. Run it from cron every minute. |

## Set up and maintain

| Command | Does |
|---|---|
| `cms install` | Installs a site: see [Installation](/getting-started/installation). |
| `cms sync` | Runs migrations and plugin install and upgrade steps, and imports `content/media`. |
| `cms packages:update` | Checks the signed update list and [updates the core](/getting-started/upgrading). `--check` only says what's on offer. `--security-only` does what an admin's visit would, for cron. |
| `cms starter:refresh --force` | Puts the Site plugin's starter kit back on this site, after a snapshot in `storage/backups/`. Accounts and settings stay. For working on the kit. |

## Users, tokens and plugins

| Command | Does |
|---|---|
| `cms user:create --email= --name= --role=` | Creates a user. `--super` makes a super administrator. |
| `cms token:create <email> --scope=… --days=` | Creates an API token for the [REST API](/agents/rest-api) or [MCP](/agents/mcp). |
| `cms plugins` | Lists plugins and modules with their status. |
| `cms plugin enable\|disable\|uninstall <name>` | Manages a plugin. `--delete-files` removes it from disk on uninstall. |
| `cms license:status`, `license:set <key>`, `license:refresh`, `license:clear` | Reads or changes the [licence](/reference/licence#paid-plugins) of a paid plugin. `license:status --json` prints the whole report. They don't show in `cms list`. |
