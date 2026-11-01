---
id: 01m5wmrf5k0mntpvx9n1354ghr
title: Requirements
position: 0
group: 'Set up'
description: 'Lettern needs PHP 8.4 or newer, a database and a handful of standard extensions.'
---
## Server

| Requirement | Notes |
|---|---|
| PHP 8.4 or newer | PHP 8.5 is supported. |
| Database | MySQL 8, MariaDB 10.6+ or SQLite 3.35+. |
| Extensions | `pdo` with your database driver, `mbstring`, `openssl`, `fileinfo`, `zip`, `curl`, and `gd` or `imagick` for images. |
| Web server | Apache with `.htaccess` (shared hosting), Nginx, Caddy or PHP's built-in server for development. |
| Writable folders | The site folder, or at least `storage/`, `config/`, `content/`, `plugins/`, `public/` and `runtime/`. |
| Network | Outgoing HTTPS, to fetch the release and plugins. |

The installer checks all of these and tells you exactly what is missing.

## Images

Lettern makes responsive WebP and AVIF variants of every uploaded image. AVIF needs GD built with AVIF support or Imagick; without it, Lettern serves WebP and the original.

## For plugin development

Building plugins with admin extensions needs Node.js 22+. Running and designing a site does not — releases carry their built assets, and the design lives in the CMS. Neither Composer nor Node is needed on the server.
