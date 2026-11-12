---
id: 01m6zp7b2x4k9q3s8v5t1n6wfr
title: Publishing in the store
position: 14
description: 'Keep your plugin on GitHub and Packagist as usual. The store fetches each release, a person reviews it, and every site gets it signed.'
---
The store on lettern.org lists the project's own plugins and, by invitation, other people's. You keep your plugin where any Composer package lives; the store takes each release from there, reviews it and hosts it. Plugins in the store are free to install for now.

[Apply to publish](https://lettern.org/store/publish) with a short form. Once you're invited, your plugin is added by its Packagist name.

## Before you apply

Your plugin is a Composer package like [your first plugin](/plugins/your-first-plugin), with:

- `"type": "cms-plugin"` and a `require` on `letterncms/cms` with the versions it works with.
- Its code in your own namespace. Only the project's plugins may use `Cms\`.
- A `CHANGELOG.md` with a heading per version, such as `## 1.2.0`: what you write under it is what sites show as the release's notes.
- A public repository on GitHub and the package on [Packagist](https://packagist.org), so `composer require vendor/plugin` works.

## How a release reaches sites

1. **Tag it.** Push a tag such as `v1.2.0` and Packagist picks it up, as it does for any package.
2. **The store fetches it.** About once an hour the store asks Packagist for new stable tags and downloads each one's zip once. It keeps one folder named after the package, writes the version into `composer.json`, and leaves out dotfiles such as `.github`.
3. **A person reviews it.** The version waits, unseen by any site, until it's approved. The review sees the code and what it may use: the network, the file system, other processes.
4. **It's signed and listed.** Approved, the version is signed with the store's key and added to the [catalog](/plugins/store-protocol). Every site that has your plugin is offered the update in **Plugins → Updates**, with your notes.

A rejected version stays out of the store, and its number stays used: fix it and tag the next one. A version number is never used twice, and never goes backwards within a major version.

Sites download your plugin from the store, not from GitHub: what they get is exactly what was reviewed, even if the tag moves later.

## Your listing

Your listing has a title, a one-sentence summary, an icon, up to three categories, at least two screenshots, a description, what it needs beyond the CMS (an account elsewhere, say), and links to your documentation and code. The CMS and PHP versions come from your `composer.json`. Once you're invited, you send them to us and we keep them up to date with you.

## Installing it

People install your plugin from **Plugins** in their admin, with one click. A site run with Composer adds the store as a repository and installs it like any package:

```bash
composer config repositories.store composer https://lettern.org/composer
composer require vendor/plugin
```
