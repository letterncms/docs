---
id: 01m5wn8r8zc4z78k38e6gb1fpk
title: Command line
position: 3
group: 'API'
description: Run abilities, build the site and manage users, tokens and plugins from the terminal.
---
Run `php cms` from your site folder.

| Command | Does |
|---|---|
| `cms install` | Install a site (see [Installation](/getting-started/installation)). |
| `cms serve --port=8000` | Development server. |
| `cms run` | List abilities. |
| `cms run <ability> key=value …` | Run an ability. Values may be JSON: `cms run entries/create collection=pages title=About 'data={"summary":"Hi"}'`, or pass the whole input with `--json='{…}'`. |
| `cms build` | Build the whole static site. `--strict` fails on warnings, such as a missing image. |
| `cms links:check` | Fail on links, images and anchors in the built site that lead nowhere. External links are left alone. |
| `cms sync` | Run migrations and plugin install/upgrade steps, and import `content/media`. |
| `cms packages:update` | Check the signed update list and [update the core](/getting-started/upgrading). `--check` only says what's on offer. `--security-only` does what an admin's visit would, for cron. |
| `cms license:status`, `license:set <key>`, `license:refresh`, `license:clear` | Read or change the [licence](/getting-started/licence#paid-plugins) of a paid plugin. `license:status --json` prints the whole report. They don't show in `cms list`. |
| `cms media:check` | Import `content/media` and report what's broken: see [Media](/content/media). `--strict`, `--json`, `--adopt`. |
| `cms plugins` | List plugins and modules with their status. |
| `cms starter:refresh --force` | Put the Site plugin's starter kit back on this site, after a snapshot in `storage/backups/`. Accounts and settings stay. For working on the kit. |
| `cms plugin enable|disable|uninstall <name>` | Manage a plugin; `--delete-files` removes it from disk on uninstall. |
| `cms user:create --email= --name= --role=` | Create a user (`--super` for a super administrator). |
| `cms token:create <email> --scope=… --days=` | Create an API token. |
| `cms publish:scheduled` | Let scheduled entries go live (run from cron every minute). |

Abilities run from the CLI act with full rights and are logged as `cli` in the audit log. Abilities can opt out of the CLI with `expose: ['cli' => false]`.
