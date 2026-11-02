---
id: 01m6c2l1cq7n4x8v0t3e9h5r2a
title: Licence
position: 6
group: 'Your project'
description: Free and open source under the MIT licence, for any use on any number of sites. Paid plugins carry a licence of their own.
---
Lettern is free and open source, under the MIT licence. The text is `LICENSE.md`, in the root of every release, and the source is [on GitHub](https://github.com/letterncms).

Use it for anything, on as many sites as you like. There is no key, no limit and no banner, and core updates and security updates are free.

## Name and logo

The MIT licence covers the code, not the Lettern name or logo. If you publish a changed copy, give it a name and logo of your own.

## What stays yours

Your content, templates and plugins are yours. Third-party components keep their own licences. Plugin authors choose their own licence, and Lettern's own free plugins are MIT too.

## Paid plugins

A paid plugin from the [store](/plugins/store-protocol) carries its own licence: paid once, per site. Commerce is the first, with its terms in `LICENSE.md` in its own folder. With Composer, a paid plugin comes from the store's own repository, with your site's domain and licence key as the login:

```bash
composer config repositories.store composer https://lettern.org/composer
composer config http-basic.lettern.org example.com "<licence key>"
composer require letterncms/commerce
```

 Its licence says nothing about Lettern, and Lettern doesn't need one.

A site with no paid plugin has no licence screen, no banner and nothing to check.

### What a licence state can do

A paid plugin's licence never stops a public site. The most any state does is show a banner in the admin, to people who can manage the licence. Public pages, static builds, the API, sign-in, editing and publishing are the same in every state, and a public request doesn't even load the licence code.

### How it is checked

A licence is a signed key that the site checks by itself, with no network. To install a paid plugin from the store, paste the key on its listing. Once a paid plugin is on, you can also paste it under **Licence** in the admin, run `php cms license:set <key>`, or set `CMS_LICENSE`. It is stored in `config/license.key`, so a clone or a copy on staging keeps it.

| Host | Needs a licence |
|---|---|
| `localhost`, an IP address, a single-word host, `.test`, `.local`, `.internal`, `.example`, `.invalid`, any port other than 80 or 443 | No |
| A first label such as `dev.`, `staging.`, `test.`, `uat.`, `qa.`, `preview.` on a host with three labels or more | No |
| Preview platforms such as `ddev.site`, `ngrok.io` and `gitpod.io` | No |
| Everything else, `.dev` and `.app` included | Yes |

The site URL you configured decides, not the request, so a proxy doesn't change the answer and neither does a spoofed header.

| State | What you see |
|---|---|
| Licensed, or a host that needs none | Nothing |
| Update window over | A line on the Licence screen. The plugin keeps working, with patches and minor releases of the versions covered |
| The server can't check signatures, or the key is newer than this copy | A line on the Licence screen |
| No licence, another domain, a refund, a new major outside the window | A banner you can dismiss for 7 days |
| A term that ended, a chargeback, a revoked licence | A banner that stays |

### What is sent

Once a day at most, while someone is signed in to the admin and never on a public page, a site with a paid plugin and a key asks for a current one: the licence id and revision, the site URL, and the Lettern and PHP versions. It runs in the background, with a 3-second limit. If it fails, nothing changes. `CMS_LICENSE_OFFLINE=true` turns it off, and you can paste a new key by hand instead.

See [Licence tokens](/plugins/licence-tokens) for the format.
