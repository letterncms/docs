---
id: 01m5wnc9yws2p0yzvc96tkd6pc
title: Hooks
position: 2
group: 'Build'
description: Actions tell you something happened; filters let you change a value on its way through. Every hook Lettern fires is listed here.
---
```php
$hooks = $this->cms()->hooks();

// Action: react.
$hooks->on('entry.published', function (Entry $entry, ?User $user) {
    Http::post('https://hooks.example.com/published', ['url' => $entry->uri]);
});

// Filter: return the (possibly changed) first argument.
$hooks->addFilter('entry.uri', fn (string $uri, Entry $entry) => $entry->collection === 'jobs' ? '/careers'.$uri : $uri);
```

Both take an optional priority (lower runs first, default 10). Prefer [abilities](/agents/abilities) for things people or agents should be able to *do*; use hooks to react and adjust.

## Actions

| Action | Arguments | Fired when |
|---|---|---|
| `entry.saved` | `$entry, $user, $action` | An entry is created, saved, published or unpublished (`$action` says which). |
| `entry.published` | `$entry, $user` | An entry goes live — also when a scheduled one comes due. |
| `entry.unpublished` | `$entry, $user` | An entry is taken offline. |
| `entry.deleting`, `entry.deleted` | `$entry, $user` | Around deletion. |
| `entry.uri-changed` | `$entry, $old, $new` | A live entry's URL changed. |
| `entry.structure-changed` | `$entry, $user` | An entry moves or its position changes. Its editorial draft stays unpublished; use this hook to invalidate structural output. |
| `entries.reordered` | `$collection, $ids, $user` | Siblings were reordered. |
| `collection.saved`, `collection.deleted` | `$collection` / `$handle` | A collection definition changed. |
| `globals.saved` | `$set` | A global set's fields or values changed. |
| `navigation.saved`, `form.saved` | `$handle` | A menu or form changed. (Templates and components are entries: use `entry.saved` and `entry.published`.) |
| `redirects.saved` | — | The redirect list changed. |
| `media.uploaded` | `$item, $user` | A file was added. |
| `media.updated`, `media.deleted` | `$item` | A file changed or was removed. |
| `form.submitted` | `$form, $data, $submission` | A valid submission arrived. |
| `comment.created` | `$comment, $entry, $author` | Someone commented. |
| `users.fields.saved` | — | The user profile fields changed. |
| `settings.saved` | `$namespace, $values` | A settings namespace was saved (`site` is `config/site.yaml`). |
| `design.saved` | — | The design system or custom code changed. |
| `site.page.built` | `$uri, $entry, $file, $page` | The static build wrote a page. |
| `site.page.removed` | `$uri, $file` | The static build removed a page. |
| `site.built` | `$manifest` | A build finished. |
| `render.begin` | `$context` | A page starts rendering. |
| `render.head`, `render.foot` | `$key, $html` | Add markup to the page's head or end of body (deduplicated by key). |
| `render.style` | `$key, $css, $order` | Add CSS to the page (blocks use this). |
| `render.depend` | `$key` | Record that the page depends on something (`entry:<id>`, `collection:<handle>`), so the static build rebuilds it when that changes. |
| `render.structured` | `$key, $data` | Add JSON-LD to the page's graph. |
| `ability.executing` | `$ability, $input, $context` | Before any ability runs. |
| `ability.executed` | `$ability, $input, $result, $context` | After it ran (letterncms/audit records changes here). |
| `user.login` | `$user` | Someone signed in to the admin. |
| `account.*` | | Public accounts: signed up, verified, signed in, deleted and more. See [Using accounts](/plugins/accounts#hooks). |
| `oauth.authorized` | `$user, $client` | An agent was granted access. |

## Filters

| Filter | Value, then arguments | Lets you change |
|---|---|---|
| `entry.creating` | `$input, $collection, $user` | Input for a new entry. |
| `entry.saving` | `$entry, $collection` | An entry right before it is stored. |
| `entry.uri` | `$uri, $entry, $collection` | An entry's URL (the languages plugin adds prefixes here). |
| `collections` | `$collections` | The list of collections (add code-defined ones). |
| `collections.defaults` | `$definition` | The initial definition returned by `collections/options`. The blocks plugin contributes an explicit blocks body; without it, the core starts with no body. Creators apply explicit values afterward. |
| `collections.settings` | `$fields, $collection` | The settings a collection offers in **Collections** (the site plugin adds its template picker). |
| `ability.input` | `$input, $ability, $context` | Validated input before the handler. |
| `ability.result` | `$result, $ability, $input, $context` | What an ability returns. |
| `users.fields` | `$fields` | The fields of user profiles (add your own). A field with `public: true` can be edited on the public profile page. |
| `gate.allows` | `$allowed, $user, $entry, $rule` | Whether someone may read a [gated](/content/gated-content) entry. |
| `settings.fields` | `$fields, $namespace` | A settings namespace's fields — add to another's, or take one over (the languages plugin manages the site's language). |
| `settings.saving` | `$values, $namespace, $stored` | Settings right before they are validated and stored. |
| `admin.manifest` | `$manifest, $user` | What the admin receives at start-up (modules add `collections`, `globals`, the home screen and `config.<namespace>` here). |
| `admin.nav` | `$items` | Sidebar items that come and go (letterncms/content adds one per collection, letterncms/settings one per settings page). |
| `revisions.keep` | `$count` | How many revisions each entry keeps (letterncms/content makes it a setting). |
| `agent.guide` | `$guide` | The instructions every AI agent gets. |
| `site.head` | `$tags, $context` | Tags in a page's `<head>`. |
| `site.foot` | `$tags, $context` | Scripts at the end of a page's `<body>`. |
| `site.scope` | `$scope, $context` | The data templates and blocks can bind to (`site`, `entry`, `globals`, `page`, `pagination`…). `$context->mode` says who the page is for: only add a signed-in person's data in `request`, as a `build` goes to a public file. |
| `site.html` | `$html, $context` | A rendered page. |
| `site.build.extras` | `$extras` | Extra files the static build writes (sitemap, feeds…). |
| `site.search.record` | `$record, $entry` | A page's search index record (`null` leaves it out). |
| `seo.alternates` | `$alternates, $entry` | `hreflang` alternates. |
| `seo.sitemap` | `$urls` | Addresses your plugin answers itself, for the sitemap: `['uri' => …, 'updated' => …]`. |
| `site.links.answered` | `$answered, $path` | Whether an address your plugin answers itself is real, so `cms links:check` accepts it. |
| `blocks.render.data` | `$data, $type` | What a block's render function receives. |
| `blocks.data-sources` | `$sources` | Lists the Repeat block can loop over — see [Plugins](/plugins/how-plugins-work#data-sources). |
| `blocks.scope` | `$scope` | Data for blocks rendered outside a page (Markdown twins, search). |
| `blocks.svg` | `$svg, $source` | Sanitize the custom SVG of an Icon block. |
| `fields.options.<name>` | `$options` | Options of select fields with `dynamic: <name>` (`templates`, `collections`, `timezones`). |
| `fields.definition.<name>` | `$field, $context` | Resolved definition of a `dynamic: <name>` field. The collection host supplies `$context['collection']`; use it for presentation such as the inherited template name. Raw collection YAML remains unchanged. |
| `blocks.variants` | `$variants` | Block variants offered to editors. |
| `blocks.folders`, `blocks.pattern-sources` | `$sources` | Folders with blocks (`block.json`) or read-only patterns (`<handle>.json`). |
| `blocks.breakpoints` | `$breakpoints` | Breakpoints for block styles. |
| `media.url`, `media.img` | `null, $image…` | How images resolve and render (point them at a CDN). |
| `form.data` | `$data, $form, $request` | A submission before it is stored. |
| `navigation.entry`, `navigation.item` | — | How menu items resolve. |
| `i18n.translator` | `null` | The machine translator (the assistant registers Claude). |
| `mcp.prompts` | `$prompts` | Prompts offered to MCP clients: the site's skills (`cms()->skills()`). |
