---
id: 01m5wnc9yws2p0yzvc96tkd6pc
title: Hooks
position: 2
description: React when something happens in Lettern, or change a value on its way through. Every hook is listed here.
---
Hooks let your plugin join in when Lettern does something. There are two kinds:

- An **action** tells you something happened: an entry was published, a form was sent. You react.
- A **filter** hands you a value on its way through, like an entry's URL or a page's HTML. You return it, changed or not.

## Use a hook

Register hooks in your provider's `boot()`:

```php
$hooks = $this->cms()->hooks();

// Action: react.
$hooks->on('entry.published', function (Entry $entry, ?User $user) {
    Http::post('https://hooks.example.com/published', ['url' => $entry->uri]);
});

// Filter: return the (possibly changed) first argument.
$hooks->addFilter('entry.uri', fn (string $uri, Entry $entry) => $entry->collection === 'jobs' ? '/careers'.$uri : $uri);
```

Both take an optional priority as a third argument: lower runs first, and the default is 10.

::: callout {"props":{"tone":"tip","text":"Hooks are for reacting and adjusting. For something people or agents should be able to do, register an <a href=\"/agents/abilities\">ability</a> instead."}}
:::

## Fire your own

Your plugin can offer hooks to others the same way. `dispatch()` fires an action, `filter()` passes a value through every filter and returns the result, and `has()` says whether anything listens:

```php
$hooks->dispatch('reviews.approved', $review, $user);
$html = $hooks->filter('reviews.card', $html, $review);
```

Name them after your plugin, so they never clash with Lettern's own.

## Actions

### Content

| Action | Arguments | Fired when |
|---|---|---|
| `entry.saved` | `$entry, $user, $action` | An entry is created, saved, published or unpublished (`$action` says which). |
| `entry.published` | `$entry, $user` | An entry goes live, also when a scheduled one comes due. |
| `entry.unpublished` | `$entry, $user` | An entry is taken offline. |
| `entry.deleting`, `entry.deleted` | `$entry, $user` | Around deletion. |
| `entry.uri-changed` | `$entry, $old, $new` | A live entry's URL changed. |
| `entry.structure-changed` | `$entry, $user` | An entry moves or its position changes. Its editorial draft stays unpublished; use this hook to invalidate structural output. |
| `entries.reordered` | `$collection, $ids, $user` | Siblings were reordered. |
| `collection.saved`, `collection.deleted` | `$collection` / `$handle` | A collection definition changed. |
| `globals.saved` | `$set` | A global set's values changed. |
| `global-set.saved`, `global-set.deleted` | `$set` / `$handle` | A global set was saved, its fields or its values, or deleted. |
| `fieldset.saved` | `$handle` | A fieldset was saved. |
| `navigation.saved`, `form.saved` | `$handle` | A menu or form changed. (Templates and components are entries: use `entry.saved` and `entry.published`.) |
| `redirects.saved` | | The redirect list changed. |

### Media, forms and comments

| Action | Arguments | Fired when |
|---|---|---|
| `media.uploaded` | `$item, $user` | A file was added, in the admin, by an ability or from a URL (`$user` is null when no one did). |
| `media.updated`, `media.deleted` | `$item` | A file changed or was removed. |
| `form.submitted` | `$form, $data, $submission` | A valid submission arrived. |
| `comment.created` | `$comment, $entry, $author` | Someone commented. |

### Settings and design

| Action | Arguments | Fired when |
|---|---|---|
| `users.fields.saved` | | The user profile fields changed. |
| `settings.saved` | `$namespace, $values` | A settings namespace was saved (`site` is `config/site.yaml`). |
| `design.saved` | | The design system or custom code changed. |

### Publishing and rendering

| Action | Arguments | Fired when |
|---|---|---|
| `site.page.built` | `$uri, $entry, $file, $page` | The static build wrote a page. On a term's archive `$entry` is the term, with the archive's address as its `uri`. |
| `site.page.removed` | `$uri, $file` | The static build removed a page. |
| `site.built` | `$manifest` | A build finished. |
| `render.begin` | `$context` | A page starts rendering. |
| `render.head`, `render.foot` | `$key, $html` | Add markup to the page's head or the end of its body (deduplicated by key). |
| `render.style` | `$key, $css, $order` | Add CSS to the page (blocks use this). |
| `render.depend` | `$key` | Record that the page depends on something (`entry:<id>`, `collection:<handle>`), so the static build rebuilds it when that changes. |
| `render.structured` | `$key, $data` | Add JSON-LD to the page's graph. |

### Abilities and people

| Action | Arguments | Fired when |
|---|---|---|
| `ability.executing` | `$ability, $input, $context` | Before any ability runs. |
| `ability.executed` | `$ability, $input, $result, $context` | After it ran (letterncms/audit records changes here). |
| `user.login` | `$user` | Someone signed in to the admin. |
| `account.*` | | Visitor accounts: signed up, verified, signed in, deleted and more. See [Using accounts](/plugins/accounts#hooks). |
| `oauth.authorized` | `$user, $client` | An agent was granted access. |

## Filters

The first argument is the value you return; the rest are there to help you decide.

### Content

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `entry.creating` | `$input, $collection, $user` | Input for a new entry. |
| `entry.saving` | `$entry, $collection` | An entry right before it is stored. |
| `entry.uri` | `$uri, $entry, $collection` | An entry's URL (Languages adds prefixes here). |
| `collections` | `$collections` | The list of collections (add code-defined ones). |
| `collections.defaults` | `$definition` | The initial definition returned by `collections/options`. The Blocks module contributes an explicit blocks body; without it, a collection starts with no body. Creators apply explicit values afterward. |
| `collections.settings` | `$fields, $collection` | The settings a collection offers in **Collections** (Site adds its template picker). |
| `revisions.keep` | `$count` | How many revisions each entry keeps (100). |
| `gate.allows` | `$allowed, $user, $entry, $rule` | Whether someone may read a [gated](/content/gated-content) entry. |
| `fields.options.<name>` | `$options` | Options of select fields with `dynamic: <name>`, in collections, settings and blocks alike: `templates`, `collections` (every collection but the system ones), `timezones`, `admin-languages`, `visitor-roles`, `components` (synced components), `sources` (what a Repeat block can list) and `button-variants` (the design system adds its own). A plugin adds a name of its own (`forms`). |
| `fields.definition.<name>` | `$field, $context` | Resolved definition of a `dynamic: <name>` field. The collection host supplies `$context['collection']`; use it for presentation such as the inherited template name. Raw collection YAML stays unchanged. |

### Abilities, settings and people

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `ability.input` | `$input, $ability, $context` | Validated input before the handler. |
| `ability.result` | `$result, $ability, $input, $context` | What an ability returns. |
| `settings.fields` | `$fields, $namespace` | A settings namespace's fields: add to another's, or take one over (Languages manages the site's language). |
| `settings.saving` | `$values, $namespace, $stored` | Settings right before they are validated and stored. |
| `users.fields` | `$fields` | The fields of user profiles (add your own). A field with `public: true` can be edited on the public profile page. |

### The admin and agents

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `admin.manifest` | `$manifest, $user` | What the admin receives at start-up (modules add `collections`, `globals`, the Dashboard and `config.<namespace>` here). |
| `admin.nav` | `$items` | Sidebar items that come and go (letterncms/content adds one per collection, letterncms/settings one per settings page). |
| `agent.guide` | `$guide` | The instructions every AI agent gets. |
| `audit.past` | `$past` | What the Audit Log calls each change once it happened, by ability name: `$past + ['forms/delete' => __('Deleted Form')]`. Give every ability of yours that changes something its words; without them the log falls back to the ability's label. |
| `mcp.prompts` | `$prompts` | Prompts offered to MCP clients: the site's skills (`cms()->skills()`). |

### Pages

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `site.head` | `$tags, $context` | Tags in a page's `<head>`. |
| `site.foot` | `$tags, $context` | Scripts at the end of a page's `<body>`. |
| `site.navigate.skip` | `$paths, $context` | The paths that always load in full when the site [navigates without page loads](/design/page-navigation): add a cart or a sign-out. |
| `site.scope` | `$scope, $context` | The data templates and blocks can bind to (`site`, `entry`, `globals`, `page`, `pagination`…). `$context->mode` says who the page is for: only add a signed-in person's data in `request`, as a `build` goes to a public file. |
| `site.html` | `$html, $context` | A rendered page. |
| `site.build.extras` | `$extras` | Extra files the static build writes (sitemap, feeds…). |
| `site.llms` | `$document` | The site's `llms.txt` before it is written: `title`, `summary` and `sections` (a list of pages per heading, each with `title`, `url`, `description` and its `entry`). Change it instead of writing a second file. |
| `schemas.documents` | `$documents` | The JSON Schema files of `content/schemas/`, by path: add your own (`'reviews.json' => $schema`). |
| `site.search.record` | `$record, $entry` | A page's search index record (`null` leaves it out). |
| `site.search.records` | `$records` | Every record of the search index, to add pages that are no entry: `['id', 'title', 'url', 'section', 'collection', 'locale', 'description', 'headings', 'text']`. |
| `site.links.answered` | `$answered, $path` | Whether an address your plugin answers itself is real, so `cms links:check` accepts it. |
| `seo.alternates` | `$alternates, $entry` | `hreflang` alternates. |
| `seo.sitemap` | `$urls, $locale` | Addresses your plugin answers itself, for the sitemap: `['uri' => …, 'updated' => …]`. With `'locale' => 'de'` an address is in that language's sitemap; without, in the default language's. `$locale` is the language whose sitemap is written, or `null` on a site with one. |

### Blocks

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `blocks.render.data` | `$data, $type` | What a block's render function receives. |
| `blocks.data-sources` | `$sources` | Lists the Repeat block can loop over: see [Data sources](/plugins/how-plugins-work#data-sources). |
| `blocks.scope` | `$scope` | Data for blocks rendered outside a page (Markdown twins, search). |
| `blocks.variants` | `$variants` | Block variants offered to editors. |
| `blocks.folders`, `blocks.component-sources` | `$sources` | Folders with blocks (`block.json`) or read-only components and sections (`<handle>.json`). |
| `blocks.breakpoints` | `$breakpoints` | Breakpoints for block styles. |

### Media, email, forms and menus

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `media.url`, `media.img` | `$url, $image` / `$html, $image, $alt, $options` | The address and markup of an image (point them at a CDN). |
| `email.colors` | `$colors` | The background, text and button colors of every email. |
| `form.data` | `$data, $form, $request` | A submission before it is stored. |
| `navigation.entry`, `navigation.item` | | How menu items resolve. |

Plugins add hooks of their own: see [Using accounts](/plugins/accounts#hooks).
