---
id: 01m5wmrf60tdbvqa24fwdwwvsv
title: Installation
position: 0
description: Get Lettern running on your own hosting in a few minutes. Upload a zip, or use Composer — you end up with the same site either way.
---
Lettern runs on ordinary PHP hosting, the kind most web hosts sell. There are two ways to install it. Pick the one that suits you: the result is exactly the same site.

::: tabs {"props":{"label":"Ways to install"}}
:::: tab-panel {"props":{"label":"Upload a zip"}}
Best for shared hosting, or if you'd rather not use a command line.

1. [Download Lettern](https://lettern.org/download). The zip is small: it fetches the rest during setup.
2. Unzip it, and upload what's inside its `site/` folder to your web root with FTP or your host's file manager.
3. Open your site's address in a browser.

Setup checks your server, then asks for your site's name, the [site kit](/design/site-kits) to start from, your database and your account. A minute later, you're in.
::::

:::: tab-panel {"props":{"label":"Composer"}}
Best if you work from a terminal or deploy with git.

```bash
composer create-project letterncms/lettern my-site
cd my-site
php cms install
```

`php cms install` asks the same questions as the browser setup. You can also open the site in a browser after `create-project` and finish there.
::::
:::

![The Dashboard you see after signing in for the first time.](/media/screens/dashboard.webp "Once setup is done, sign in at /admin and you land on the Dashboard.")

## What you need

Most PHP hosting already has all of this. Setup checks every item and tells you exactly what's missing.

| | |
|---|---|
| PHP | 8.4 or newer |
| A database | MySQL 8, MariaDB 10.6+, or SQLite (nothing to set up) |
| PHP extensions | `pdo`, `mbstring`, `openssl`, `fileinfo`, `zip`, `curl`, and `gd` or `imagick` |
| A web server | Apache (works as is), Nginx or Caddy |
| Internet access | The server must be able to download over HTTPS, to fetch Lettern and plugins |

::: callout {"props":{"tone":"tip","text":"Using MySQL? Create an empty database in your hosting control panel first, and keep its name, user and password at hand. With SQLite there's nothing to create."}}
:::

## Choosing plugins

The design system, templates and publishing, media, menus, email, the block editor, languages, collaboration, MCP, the AI assistant and Sync come with Lettern. During setup you pick your plugins. The recommended ones are already ticked: SEO and Forms. Leave them as they are if you're not sure — you can add or remove any plugin later, from **Plugins** in the admin.

## Keeping it up to date

A site installed from the zip updates itself: one click under **Plugins → Updates**. With Composer, run `composer update`. See [Upgrading](/getting-started/upgrading).

## Next

Your site is running. Now [build your first page](/getting-started/quick-start).

## For developers

### Install without questions

Pass everything as options, for scripts and CI. Leave out `--db` and its options to use SQLite.

```bash
php cms install --site-name="Acme" --site-url="https://acme.test" \
  --db=mysql --db-database=acme --db-username=acme --db-password=secret \
  --name="Ada Lovelace" --email=ada@acme.test --password="a-strong-password"
```

Choose plugins with `--plugins=seo,forms`, or none at all with `--plugins=none`: a site without plugins is a complete site. `--kit=<name>` starts it from a [site kit](/design/site-kits) other than Minimal, and `--kit=none` from nothing. From the command line, plugins are added with `composer require letterncms/<name>`, and land in `plugins/<name>` (a third party's in `plugins/<vendor>-<name>`). **Plugins** puts them in the same place on a Composer site too, and adds them to `composer.json`; the next `composer update` writes them into `composer.lock`.

### Protect the installer

Until Lettern is installed, every address leads to setup, and APIs answer `503 not_installed`. On a public server, set an install token in `.env` first, so nobody else can finish setup before you:

```bash
CMS_INSTALL_TOKEN=a-long-random-string
```

### The database

If the connection fails, setup says whether the database is missing, the login was refused or no server answered. Lettern only installs into an empty database. To share one with another site, set a table prefix. SQLite lives in `storage/`.

### From the zip to Composer

A site installed from the zip is already a Composer project: `composer.json` lists what it uses. To let Composer take over, run this in the site's folder. Content, settings and the database stay as they are.

```bash
rm -rf runtime
composer update
```

### Images

Lettern makes WebP and AVIF versions of every uploaded image. AVIF needs GD built with AVIF support, or Imagick; without it, visitors get WebP and the original.

### Local development

`php cms serve` starts a development server on port 8000. Building plugins with admin screens needs Node.js 22 or newer; running and designing a site never does.

### Web server rules

**Apache** works out of the box with the included `.htaccess`: built pages in `public/` are served directly, everything else goes through `index.php`, and `config/`, `content/`, `plugins/`, `storage/`, `runtime/` and `vendor/` are never served. Lettern needs to write to its own folder, or at least to `storage/`, `config/`, `content/`, `plugins/`, `public/` and `runtime/`.

The media library has rules of its own in `public/media/.htaccess`, which Lettern writes and writes again whenever it differs, on existing sites too: the right type for 3D models, textures and Rive files, `nosniff` on every file, and a long cache for the files a script loads. Change `public/.htaccess` for rules of your own, not this file. In git, commit it or ignore it.

`public/.htaccess` itself has a block Lettern keeps current, between `# BEGIN cms` and `# END cms`: built pages are sent with `nosniff`, and with the site's [content security policy](/operations/security#content-security-policy) when it is on. What you write outside the block stays as it is; a site installed before gets the block on `cms migrate`.

```apacheconf
<IfModule mod_mime.c>
    AddType model/gltf-binary .glb
    AddType model/gltf+json .gltf
    AddType image/vnd.radiance .hdr
    AddType image/ktx2 .ktx2
    AddType application/vnd.rive .riv
</IfModule>
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    <FilesMatch "\.(glb|gltf|hdr|ktx2|riv|json)$">
        Header set Cache-Control "public, max-age=31536000, immutable"
    </FilesMatch>
</IfModule>
```

**Nginx**: point the root at your site folder and mirror the same rules, these included.

```bash
location / {
    try_files /public$uri /public$uri/index.html /index.php?$query_string;
}
location ~ ^/(config|content|plugins|runtime|storage|vendor)/ { deny all; }
location ~ ^/(composer\.json|composer\.lock|bundle\.json|setup\.php)$ { deny all; }
location ~ \.php$ {
    try_files $uri =404;
    fastcgi_pass unix:/run/php/php8.4-fpm.sock;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```
