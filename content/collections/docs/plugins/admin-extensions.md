---
id: 01m5wnc9ysp593167qe550r20c
title: Admin extensions
position: 5
group: 'Admin'
description: Add screens, sidebar items, panels, field types, dashboard widgets and commands to the admin — with the same SDK and components Lettern uses.
---
A plugin's admin code is an ES module, built with Vite to `dist/admin.js` and loaded with `$this->adminModule()`. It imports from three shared packages the admin provides at run time:

| Package | Holds |
|---|---|
| `react` | React 19 — one copy for everyone. |
| `@letterncms/sdk` | Talking to Lettern: `t` and `plural` (translations), `brand` (the product's name, links and images: never write the name, and in a translated string use the `{brand}` placeholder, as in `t('Ask {brand}')`), `run`, `request`, `eventStream`, `useAbility`, `useAction`, `invalidate`, the router (`navigate`, `Link`, `useLocation`, `useTab` — tabs kept in the URL as `?tab=`, so a refresh opens the same one), `can`, `useManifest`, `useScreenContext`, `registry` and `events`. |
| `@letterncms/ui` | The admin's primitives: `Button`, `IconButton`, `Input`, `Textarea`, `Select`, `Switch`, `Checkbox`, `Segmented`, `Tabs`, `Field`, `Fields`, `Page`, `Section`, `List`, `Dialog`, `confirm`, `Popover`, `Menu`, `SidebarRow`, `Tooltip`, `Badge`, `Avatar`, `Spinner`, `EmptyState`, `SortableTree`, `BlueprintEditor`, `FieldsEditor`, `Icon` and `toast`, plus `useShortcut`, `slugify` and the color scheme. |
| `@dnd-kit/*` | Drag and drop (`core`, `sortable`, `utilities`) — shared, so no module bundles its own. |

Using them keeps your screens consistent with the rest of the admin, in light and dark. The admin's own [modules](/plugins/modules) are built with exactly these — nothing more.

Widgets are also available to the assistant automatically. For contextual component props and generated layouts, use the same module registry with the [generative UI SDK](/plugins/generative-ui). `Surface` and `WidgetSlot` from `@letterncms/ui` provide shared rendering across Home, chat and other admin hosts.


## Consistent overview views

Use `DataView` from `@letterncms/ui` for record overviews. It provides the same Table, Grid and Calendar views as Content collections, with search, sortable headers, a Display menu, saved column/view preferences, loading and error states, and keyboard navigation (`j`/`k`, `x`, Enter and Escape). Give each overview a stable `id`; preferences are saved per account under `overview.<id>`. **Published** and **Updated** are standard columns, hidden initially outside content entry lists and always available through Display. Do not declare them in each screen.

Overview records implement the SDK's `RecordTimestamps` contract: `publishedAt` and `updatedAt`, as ISO 8601 strings or `null`. Unknown history and inapplicable publication dates appear as `—`. Entries use their publication lifecycle; menus, redirects, collections, globals and forms are published when first saved; media when uploaded. Users, private submissions, audit events and package state have no publication date. Existing records keep unknown publication history as `null`. Saves track update dates on the server; bulk redirect saves preserve unchanged rows. Language metadata follows changes to each language's effective settings.

For wrapped rows, pass `dates={(row) => row.record}`. For server-paginated sorting, declare supported fields with `dateSort={{ published: 'published_at', updated: 'updated_at' }}` alongside `onSort`. Otherwise the shared view sorts dates locally, newest first, with missing dates last. Content entry tables, trees and cards use the same date definitions and formatting.

Every overview uses `OverviewControls` for the same view choices, Display menu and **Reset display** action. Calendar groups records by Published or Updated, selected in Display and saved per overview. Records without the selected date appear under **No date**. Month navigation and expandable busy days come from `DataCalendar`. For a paginated source, supply `source={{ ability: 'reviews/list', input: filters, perPage: 100 }}`: the shared loader reads all matching pages through the ability cache, with at most four requests in flight, and handles loading, retries and invalidation. Do not build a screen-specific calendar or silently render only the current page. Content collections only adapt their date-range filters; they use the same renderer and page loader.

```typescript
<DataView
  id="reviews"
  label={t('Reviews')}
  items={reviews}
  rowKey={(review) => review.id}
  rowHref={(review) => `/reviews/${review.id}`}
  searchText={(review) => review.title}
  columns={[
    { id: 'title', label: t('Title'), value: (review) => review.title, render: (review) => review.title },
    { id: 'rating', label: t('Rating'), value: (review) => review.rating, render: (review) => review.rating },
  ]}
  empty={<EmptyState title={t('No reviews yet')} />}
/>
```

The first column identifies the record and stays visible. Set `hiddenByDefault: true` on optional details to keep them available in Display without showing them initially. Use fixed or fractional column widths so values cannot shift the grid between rows. `value` enables sorting of a complete local list. For paginated APIs, pass `sort` and `onSort`, declare the API field in each sortable column's `sort`, and sort on the server before pagination. Place server search and filters in `toolbar`. Use `selection={{ ids, onSelect }}` with `SelectionBar` for bulk actions. Pass `pagination={{ page, pages, total, perPage, onPage }}` to the shared view; it hides page controls in Calendar. `actions` renders the same record controls in all three views; `image` supplies a card preview, and `defaultView="grid"` starts with cards.

For specialized collections such as trees, compose the same `DataTable`, `TableFrame`, `TableRow`, `TableHeader`, `DataGrid`, `DataCard`, `DataCalendar` and `OverviewControls` primitives. Add missing behavior to the shared primitives rather than introducing another overview pattern.

## Build setup

A module builds with three npm packages, as ordinary `devDependencies`: `@letterncms/admin` (the Vite setup and `theme.css`), `@letterncms/sdk` and `@letterncms/ui` (types; the admin provides the code at runtime). [Your first plugin](/plugins/your-first-plugin) has the whole file.

```javascript
// vite.config.mjs
import { defineConfig } from 'vite'
import { cmsAdminModule } from '@letterncms/admin/vite'

export default defineConfig(cmsAdminModule({ entry: 'admin/src/index.tsx' }))
```

For CSS, import Tailwind's utilities into the `plugins` layer. The shared setup moves your variant utilities (`md:`, `hover:`, `dark:`…) into the admin's `variants` layer at build time, so they win over plain utilities whichever stylesheet those come from:

```css
@import "tailwindcss/theme" layer(theme);
@import "tailwindcss/utilities" layer(plugins);
@import "@letterncms/admin/theme.css";
```

## Registering things

On the PHP side, add sidebar items, commands and widgets; on the JS side, the components behind them.

```php
$admin = $this->cms()->admin();
$admin->section('shop', 'Shop', order: 30);
$admin->nav('reviews', ['label' => 'Reviews', 'path' => '/reviews', 'icon' => 'star', 'section' => 'shop', 'pinned' => true, 'permission' => 'reviews.manage']);
$admin->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star', 'column' => 'main', 'permission' => 'reviews.manage']);
$admin->command('reviews-new', ['label' => 'Moderate reviews', 'path' => '/reviews', 'keywords' => ['ratings']]);
```

```typescript
import { registry } from '@letterncms/sdk'
import { lazy } from 'react'

registry.routes.set('/reviews', { path: '/reviews', component: lazy(() => import('./ReviewsScreen')) })
registry.widgets.set('reviews-latest', lazy(() => import('./WidgetLatest')))
registry.fields.set('rating', RatingField)
registry.commands.set('reviews-ask', { id: 'reviews-ask', label: 'Summarize reviews', perform: () => { /* … */ } })
```

Screens can prepare their required data before navigation commits. Add a `load(params, location)` function to the route and use `prefetchAbility` with the same ability and input as the screen's `useAbility` call:

```typescript
import { prefetchAbility, registry } from '@letterncms/sdk'

registry.routes.set('/reviews/:id', {
  path: '/reviews/:id',
  component: lazy(() => import('./ReviewEditor')),
  load: ({ id }) => prefetchAbility('reviews/get', { id }),
})
```

The admin starts loading code and data on link hover or focus. While an uncached destination loads, the current screen stays visible with the shell's progress indicator; cached results open immediately and stale data refreshes in the background. `location.query` contains the destination's query parameters. Prepare independent queries with `Promise.all`. Loaders must only read data: they can run before a link is followed. A later navigation takes precedence over an earlier request. Fetch errors still open the destination so its error and retry UI can handle them.

### The sidebar

The sidebar has two states, both drawn from registered sections and items. The screen on view decides which one shows:

- **The main sidebar** — the items each person *pinned*, section by section, then **More** for every other item. The kernel registers the sections `main` (no heading) and `content`, so the main sidebar is about content; each collection is an item too (`collection.<handle>`, in the section its definition names, pinned unless it is a system collection like templates and components).
- **The settings sidebar** — on any settings page: a way back, then the settings pages in `settings` sections. The kernel registers `account` (no heading), `site`, `tools` and `system` (*Administration*), and the blocks and site plugins add `design`; each settings namespace is an item (`settings.<namespace>`, in the section it was registered with). Settings are a place to visit, not something to arrange: these items are never pinned and keep their registered order.

| Item key | Meaning |
|---|---|
| `label`, `path`, `icon` | What the row shows and where it goes. |
| `section` | The section it is listed in — of the main sidebar, or of the settings sidebar when the section is registered with `settings: true`. |
| `order` | Its default place in the section. |
| `pinned` | In everyone's sidebar until they pin their own; otherwise it waits under **More**. Keep it for screens people open every week. |
| `shortcut` | A key that opens it, shown with the label (e.g. `mod+j`). |
| `placement` | `footer` takes it off the list: a `sidebar.footer` panel draws it, under the same pin (the assistant's chat). |
| `permission` | Who may open it. `visible` (a `fn (User $user): bool`) decides per person beyond that — the assistant shows its chat only once it can work, or to those who can set it up. |
| `badge` | A callable returning a count (new form submissions), shown with the label. |

```php
$admin->section('shop', 'Shop', order: 30);                       // a section of the main sidebar
$admin->section('billing', 'Billing', order: 15, settings: true); // a section of the settings sidebar
```

Every row in the sidebar — pinned, under More, settings — and every `SidebarRow` a plugin draws behaves the same: a label too long for the row slides to show its end on hover, the row's main action (**Unpin**, **Pin to Sidebar**, **Delete Chat**) shows as a button on hover, and right-click (long-press on touch) lists everything the row can do, starting with **Open in New Tab**. Everyone pins their own sidebar: **Pin to Sidebar** in **More**, **Unpin**, **Move Up** and **Move Down** on a row, drag to reorder, or **Customize Sidebar…** (in More, the site menu and `⌘K`) for every item at once. Their arrangement is the `sidebar` preference; until they make one they see the site's default — **Save as Default** in Customize Sidebar writes it to the `sidebar` value of the `admin` settings, **Settings → Admin** resets it. A new item lands in its section after what is there, pinned or not as registered; an item that disappears (a plugin turned off) keeps its place for when it returns. Items under More stay in `⌘K` — pinning is about focus, the item's `permission` decides access.

A module puts its own item away or back with `events.emit('sidebar.pin', { id, pinned })` (unpinning offers **Undo**); `events.emit('sidebar.customize')` opens Customize Sidebar.

### Home-screen widgets

**Every plugin registers at least one widget.** The home screen is what people see first, so each plugin brings something worth a glance there — new submissions, the health of a connection, what changed. A plugin without a widget keeps working but is reported as invalid: **Modules** shows the problem, `cms plugins` lists it (and exits with an error, so CI catches it) and, in debug mode, the home screen names it. The admin's own modules are exempt — they are the admin itself.

| Key | Meaning |
|---|---|
| `label`, `icon` | The widget's header and its card in the gallery. |
| `description` | One short sentence for the gallery: what it shows. |
| `column` | Where it lands when added: `main` (wide) or `side` (narrow, the default). |
| `enabled` | On everyone's home screen until they rearrange it. Leave it off: only *Recently edited*, *Site* and *Analytics* start on, so nobody is overwhelmed. People add the rest from the gallery. |
| `permission` | Who may see and add it. |
| `order` | Its place among the others in a column. |

People customize their home screen on the home screen itself: **Customize** lets them drag widgets within and between the columns, remove them and add more from the gallery, which shows every widget with its description and the plugin it comes from. The result is their own (the `dashboard` value of their preferences); until they make one they see the site's default, which admins set with **Save as Default** — it is the `dashboard` value of the `admin` settings, and the `admin/arrangement` ability returns it for agents.

Draw the widget with `Widget` from `@letterncms/ui`. It takes the registered label and icon for its header and handles loading, errors and the empty state, so every widget looks and behaves the same; `WidgetRow`, `Stat`, `Delta`, `Sparkline`, `Meter`, `BarRow` and `compactNumber` are the parts the built-in widgets are made of:

```typescript
import { t, timeAgo, useAbility } from '@letterncms/sdk'
import { Widget, WidgetRow } from '@letterncms/ui'

export default function WidgetLatest() {
  const reviews = useAbility<Review[]>('reviews/latest', { limit: 5 })

  return (
    <Widget action={{ label: t('All reviews'), to: '/reviews' }} query={reviews} empty={reviews.data?.length === 0 && { icon: 'star', title: t('No reviews yet') }}>
      {reviews.data?.map((r) => <WidgetRow key={r.id} to={`/reviews/${r.id}`} icon="star" title={r.title} meta={timeAgo(r.createdAt)} />)}
    </Widget>
  )
}
```

The body is a size container: adapt to the column with container variants such as `@md:grid-cols-4`. Give a widget the data it needs through a read-only ability — agents can use it too.

| Registry | For |
|---|---|
| `routes` | Screens. `layout: 'full'` hides the sidebar (editors). `overlay: true` draws one over the screen it was opened from, which stays open underneath: go there and back with `navigate(path, { overlay: true })`, which doesn't ask about unsaved changes. `private: true` keeps a screen's title and text out of `useScreenContext` readers. |
| `fields` | The editing component for a field type. |
| `panels` | Components in named slots — see below. |
| `widgets` | Home-screen widgets (declared in PHP, rendered from here). |
| `commands` | Command palette entries. `acceptsQuery: true` offers the command for any typed text. |
| `icons` | Extra icons by name. |

## Forms are fields

Every form in the admin — sign-in, settings, dialogs, toolbars, search boxes, the block workspace inspector — is a list of field definitions drawn by `Fields`. Raw inputs live only inside field components (`registry.fields`), so a screen never hand-builds a control:

```typescript
import { Fields, prompt } from '@letterncms/ui'

<Fields
  layout="inline"                      // compact rows, label left; default "stacked"
  className="flex items-center gap-2"   // a toolbar row
  fields={[
    { handle: 'q', type: 'text', label: 'Search', icon: 'search', size: 'sm', className: 'w-72' },
    { handle: 'status', type: 'select', label: 'Status', display: 'segmented', options: { all: 'All', open: 'Open' } },
  ]}
  values={filters}
  onChange={(handle, value) => setFilters({ ...filters, [handle]: value })}
/>

const answer = await prompt({ title: 'New list', fields: [{ handle: 'name', type: 'text', label: 'Name' }] })
```

Presentation options the core components understand: `icon`, `size` (`xs` for inspectors, `sm`, `md`, `lg`), `placeholder`, `autofocus`, `autocomplete`, `inputmode`, `mono`, `className` (the field's wrapper); text `commit: 'blur'`; select `display: 'segmented'` (with `block`), option objects with `icon` and `title`, `numeric`; toggle `display: 'checkbox'`; number `suffix` and `step`. In inline rows, `status` (`own` or `inherited`) colors the label and `reset` makes it clear the value. When core cannot express a control — a CSS length with tokens, a color with alpha — register a field component and point a field at it with `component`.

Custom field controls use `fieldControlId(field)` from `@letterncms/ui` for their control ID and `field.describedBy` for `aria-describedby`. `Fields` supplies these values so labels, errors and focus targets stay connected. Nested field renderers pass `context.path` with their parent handle (and the row index for repeaters), and retain `context.errors`; a nested `seo.title` must not reuse the document title’s ID.

Date fields accept `time: true` and an IANA `timezone`, such as `Europe/Brussels`. The control shows that zone, converts wall times to UTC instants, and rejects missing or ambiguous daylight-saving times with a visible error.

## Translations

The admin speaks English, Dutch and French, and every string you show should too. Write it in English and wrap it in `t()` — the English text is its own key:

```typescript
import { plural, t } from '@letterncms/sdk'

<Button>{t('Send test email')}</Button>
toast.success(t('Sent to {email}', { email }))
plural(count, '{count} submission', '{count} submissions')
```

Ship the translations in your package as `lang/<code>.json` — `{ "Send test email": "Testmail versturen" }`. The admin merges the core's and every active package's dictionaries for the user's language; a missing string shows in English. PHP reads the same files: use `__('…')` for messages you write, and labels you register (nav items, widgets, settings fields, permissions) are translated for you when they reach the admin.

Each person picks their language in Account → Appearance; Settings → Admin sets a default for everyone else, and without one the browser's language is used (English when Lettern doesn't speak it) — the sign-in screen included. Dates and numbers follow it (`locale()` from `@letterncms/sdk`).

## Slots

| Slot | Where | Props |
|---|---|---|
| `entry.toolbar` | Entry editor toolbar | `EntryPanelProps`: `entry`, `collection`, `content`, `values`, `title`, `setValue`, `save`, `reload`, `editable`, `can`, `errors` |
| `entry.sidebar` | Tabs in the entry side panel (give `label` and `icon`) | Same |
| `entry.body` | Extra content after the main body, supplied through the workspace footer | Same |
| `entry.editor` | The shared body workspace for the explicitly configured blocks field | `EntryEditorProps` |
| `shell.aside` | Workspace panels available on every screen, over the screen | `full` |
| `shell.dock` | A column between the sidebar and the workspace, on every screen. Draw it with `Dock` from `@letterncms/ui` (`open`, `full`, `label`): the sidebar keeps to its rail beside it, the page stays usable next to it, people can drag it wider, and small windows get it over the page — the assistant's chat | `full` |
| `sidebar.footer` | Above the account in the sidebar, in both its states — the way to the assistant's chat. Go with a nav item of `placement: footer` to share its pin | `collapsed`, `onNavigate` |
| `account.sections` | A section of **Account** — core's profile, password, two-factor, appearance and tokens are panels here too (order 10–60); the MCP plugin adds *Connect an AI agent* at 50 | — |

```typescript
registry.panels.set('reviews-summary', { id: 'reviews-summary', slot: 'entry.sidebar', label: 'Reviews', icon: 'star', component: ReviewsPanel, when: (p) => p.collection.handle === 'products' })
```

`EntryPanelProps` is exported by `@letterncms/sdk`. `entry` is `null` until the first save. Every entry panel receives `content: EntryContent`, the complete current working snapshot of `title`, `slug`, `data` and `authorId`; `values` and `title` expose its data and title separately. Use `editable` to disable editing, `can` for the collection's `create`, `edit`, `publish` and `delete` capabilities, and `errors` for field validation messages. Panels must respect these capabilities rather than assuming everyone can edit or restore a version.

The site plugin owns the single toolbar **Preview** dialog. It previews the complete unsaved snapshot, including before the first save, with `play: true` through the site renderer. Extensions can request this same action with `events.emit('entry.preview')` from `@letterncms/sdk` instead of adding another preview control or rendering store. A screen that needs the room can fold the admin sidebar to its rail with `events.emit('shell.compact', true)` and release it with `events.emit('shell.compact', false)` when it unmounts; the entry editor does this.

### What's on the screen

Something working alongside a screen (the assistant's chat) can read what that screen is about. Any screen is known by its title and its text. A screen can say more, for as long as a component is mounted:

```typescript
import { useScreenContext } from '@letterncms/sdk'

useScreenContext({
  kind: 'order',
  data: () => ({ id: order.id, status: order.status }),  // read only when it's needed; takes the place of the screen's text
  selection: line ? { id: line.id, label: line.title, data: () => line } : null,
  flush: () => save(),                                   // bring it up to date before someone reads or changes it
})
```

The entry editor gives the entry and saves first; the block workspace gives the selected block. To read it, use `useScreen()`, or `screenContext.get()` and `screenText(limit)`. A screen with something to keep to itself sets `private: true` on its route. After changing content from outside a screen, `events.emit('content.changed')` makes an open entry editor show the new version, unless it has unsaved edits.

A sidebar panel that edits blueprint fields declares their handles with `fieldHandles` on its registration:

```typescript
registry.panels.set('product-reviews', {
  id: 'product-reviews', slot: 'entry.sidebar', label: t('Reviews'),
  component: ReviewsPanel, fieldHandles: ['reviews'],
  when: (p) => p.collection.handle === 'products',
})
```

The entry host routes claimed fields to active panels. Unclaimed fields remain available in the normal entry UI, including fields from custom sections or a disabled plugin. A field's section name alone does not hide it. Declare only the handles the panel actually renders; show their validation errors there. The shared sidebar always starts with the collection's singular-name details tab, then History, then plugin panels.

## Block workspace

The `entry.editor` slot supplies the shared block workspace. The content host mounts it only when the collection explicitly names a `body` field whose type is `blocks`. It does not infer a body from field order or choose an editor based on a collection flag. Collections without a blocks body use the normal field form. A `markdown` field remains a raw text/code field, not another content workspace.

```typescript
import type { EntryEditorProps } from '@letterncms/sdk'

registry.panels.set('blocks-editor', {
  id: 'blocks',
  slot: 'entry.editor',
  label: 'Blocks',
  icon: 'blocks',
  component: lazy(() => import('./BlocksWorkspace').then((m) => ({ default: m.BlocksWorkspace }))),
  when: (p: EntryEditorProps) => p.bodyField.type === 'blocks',
})
```

The host owns working content, persistence, publication, permissions and entry details. `EntryEditorProps` extends `EntryPanelProps`:

| Prop | Holds |
|---|---|
| `entry`, `collection`, `values`, `title` | The entry and its working values. |
| `content` | The complete working snapshot inherited from `EntryPanelProps`: `title`, `slug`, `data` and `authorId`. |
| `bodyField` | The explicitly configured main-content field. |
| `setValue(handle, value)`, `setTitle(title)` | Change the working copy through the host. |
| `save()`, `reload()` | Save now; reload from the server. Save failures reject so extensions can handle them. |
| `editable`, `can`, `errors` | Editing access, action capabilities and field validation errors. |
| `footer` | Applicable `entry.body` plugin panels; render after the live surface in a bounded scrolling area. |
| `sidebar` | Host-rendered entry details, History and plugin tabs. |
| `sidebarOpen`, `setSidebarOpen(open)` | Sidebar visibility and its setter. |

The workspace renders the supplied footer and sidebar rather than recreating metadata controls or tab ordering. The host keeps the entry title and collection fields in Details, with claimed fields in their plugin panels. The body uses the existing site renderer with rendered block IDs bridged to the shared store. A template's exact `entry.title` text binding can also edit the title inline through `setTitle`; both controls use the same working snapshot. Sample titles while editing templates or components remain read-only.

Selecting a block opens the shared Content, Design and Interact inspector; returning to entry details restores the host sidebar. Outline and insertion between rendered sections use the same complete compatible block catalog. Rendered components, sample content and repeated items retain their source provenance rather than becoming editable nodes in the owning body. Preview does not own a second editing store.

## Sharing a module

A plugin can expose its module to others through the import map — the forms plugin builds on the block editor this way:

```php
$this->adminModule(import: '@acme/reviews');
```

Other modules then `import { … } from '@acme/reviews'` and list it in `externals` of `cmsAdminModule`.
