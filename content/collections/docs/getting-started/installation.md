---
id: 01m5wmrf60tdbvqa24fwdwwvsv
title: Installation
position: 1
group: 'Set up'
description: Upload a small zip and open it in a browser, or use Composer. Both end up with the same site.
---
There are two ways in. They give you the same site, in the same folders, on the same code.

Nothing is preinstalled: you choose your plugins during setup, and can add or remove any of them later.

## With a zip

For shared hosting and anyone who just wants a site.

1. [Download the zip](https://lettern.org/download). It is small, because it holds only what is needed to fetch the rest.
2. Unzip it and upload the contents of its `site/` folder to your web root.
3. Open your site in a browser.

Lettern checks your server, fetches the release, then asks for your site's name, the database and your account, and which plugins you want. It needs a little over a minute and nothing but PHP. The server has to be able to make outgoing HTTPS requests; see [Requirements](/getting-started/requirements).

A site set up this way [updates itself](/getting-started/upgrading) from the admin.

## With Composer

For teams that deploy, and anyone with a shell.

```bash
composer create-project letterncms/lettern my-site
cd my-site
php cms install
```

`php cms install` asks for the same things as the browser, then adds the recommended plugins with `composer require`. Choose others with `--plugins=site,blocks,forms`, or none with `--plugins=none`. You can also open the site in a browser after `composer create-project`, and set it up there.

To install without any prompts:

```bash
php cms install --site-name="Acme" --site-url="https://acme.test" \
  --db=mysql --db-database=acme --db-username=acme --db-password=secret \
  --name="Ada Lovelace" --email=ada@acme.test --password="a-strong-password"
```

Leave out `--db` and its options to use SQLite.

## Choosing plugins

Setup offers everything in the store, with the recommended plugins ticked: the builder and static site, media, navigation, SEO, forms, email, the assistant and MCP. A site with no plugins at all is a working, headless CMS.

Add more whenever you like, from **Modules → Store** in the admin or with `composer require letterncms/<name>`. Either way a plugin lands in `plugins/<name>`, and a third party's in `plugins/<vendor>-<name>`.

## Moving from the zip to Composer

The folder is already a Composer project: `composer.json` lists what the site uses. When you have a shell and want Composer to take over:

```bash
rm -rf runtime
composer update
```

The site keeps its content, settings and database. From then on you update with Composer.

## The database

Create the MySQL database in your hosting control panel first. If the connection fails, the installer says whether the database is missing, the login was refused or no server answered. Lettern only installs into an empty database; to share one with another site, set a table prefix. Choose SQLite and there is nothing to create: it lives in `storage/`.

## Protect the installer

Until Lettern is installed, every address leads to the installer (APIs answer `503 not_installed`). On a public server, set an install token first so nobody else can finish it before you. Put this line in `.env`, and the installer asks for the token:

```bash
CMS_INSTALL_TOKEN=a-long-random-string
```

## Sign in

Go to `/admin` and sign in. The home screen shows recent edits, visitors and whether the published site is up to date; **Customize** adds more widgets.

::: callout {"props":{"tone":"tip","text":"Running locally? <code>php cms serve</code> starts a development server on port 8000."}}
:::

## Web server notes

**Apache** works out of the box with the included `.htaccess`: built pages in `public/` are served directly, everything else goes through `index.php`, and `config/`, `content/`, `plugins/`, `storage/`, `runtime/` and `vendor/` are never served.

**Nginx** — point the root at your site folder and mirror the same rules:

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
