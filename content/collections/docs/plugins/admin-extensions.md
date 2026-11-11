---
id: 01m5wnc9ysp593167qe550r20c
title: Admin extensions
position: 6
description: Add screens, sidebar items, editor panels, field types, Dashboard widgets and commands to the admin, with the same tools Lettern uses.
---
Your plugin can add to the admin: a screen of its own, a tab in the entry editor, a field type, a widget on the Dashboard, a command in `⌘K`. Screens are data first: a list, a form, tabs and buttons bound to your abilities are a [view](/plugins/views), drawn by Lettern with no React of yours. What a view can't draw, such as an editor, a panel or a field type, you write in React with the same SDK and components Lettern's own screens are made of, so it looks and behaves like the rest of the admin, in light and dark.

## Add a screen

Start with a [view](/plugins/views). For a screen that is itself an editor, there are two parts: PHP declares the sidebar item, and your admin module draws the screen.

```php
// In your provider's boot()
$this->cms()->admin()->nav('reviews', ['path' => '/reviews', 'icon' => 'star', 'section' => 'content']);
$this->adminModule();
```

```typescript
// admin/src/index.tsx
import { registry, t, useAbility } from '@letterncms/sdk'
import { Page } from '@letterncms/ui'

function ReviewsScreen() {
  const reviews = useAbility<{ id: string; title: string }[]>('reviews/list', {})

  return (
    <Page crumbs={[{ label: t('Reviews'), icon: 'star' }]}>
      {reviews.data?.map((review) => <p key={review.id}>{review.title}</p>)}
    </Page>
  )
}

registry.routes.set('/reviews', { path: '/reviews', component: ReviewsScreen })
```

Build it to `dist/admin.js` (see [Build setup](#build-setup)), and **Reviews** appears under **Content** in the sidebar. Without a `label`, a plugin's main screen takes the plugin's name, `extra.cms.label` in its `composer.json`, so the screen, its settings and its row in **Plugins** are all called the same. `useAbility` runs one of your [abilities](/agents/abilities) with the signed-in person's permissions, so the screen never sees more than they may.

## What you can import

Your admin code is an ES module, built with Vite to `dist/admin.js` and loaded with `$this->adminModule()`. It imports from shared packages the admin provides at runtime, so your bundle holds only your own code:

| Package | Holds |
|---|---|
| `react` | React 19: one copy for everyone. |
| `@letterncms/sdk` | Talking to Lettern: `t` and `plural` (translations), `brand` (the product's name, links and images: never write the name, and in a translated string use the `{brand}` placeholder, as in `t('Ask {brand}')`), `run`, `request` (and `requestText`, for an answer that is text, such as the site's rendering of a page), `eventStream`, `useAbility`, `useAction`, `invalidate`, the router (`navigate`, `Link`, `useLocation`, `useTab`: tabs kept in the URL as `?tab=`, so a refresh opens the same one, and `confirmLeaving()`, which the admin uses to ask about unsaved changes in its own dialog), `can`, `useManifest`, `setPreference` (one of the signed-in person's preferences: this session's copy changes at once, their account follows), `useScreenContext`, `registry` (with `registry.composer` for `@` and `/` in a thread) and `events`. |
| `@letterncms/ui` | The admin's primitives: `Button`, `IconButton`, `Input`, `Textarea`, `Select`, `Switch`, `Checkbox`, `Segmented` and `Tabs` (both take `fit`: one line that shrinks to the room there is; a tab can have an `icon`), `Field`, `Fields`, `Page`, `Section`, `ScreenTabs`, `ScreenSidebar`, `SaveBar`, `List`, `Dialog`, `confirm`, `prompt`, `Popover`, `Menu`, `SidebarRow`, `Tooltip`, `Badge`, `Notice`, `QueryError`, `Avatar`, `PersonPicker`, `Spinner`, `EmptyState`, `SortableTree`, `BlueprintEditor`, `FieldsEditor`, `Icon` and `toast`, plus `copyText` (the clipboard, saying how it went), `formatBytes` (a file size in the admin's language), `deviceWidths` (the tablet and phone widths previews use), `useShortcut` (give it a label, `useShortcut('mod+shift+p', publish, true, t('Publish'))`, and the key is listed when someone presses `?`), `slugify` and the color scheme. |
| `@dnd-kit/*` | Drag and drop (`core`, `sortable`, `utilities`), shared so no module bundles its own. |

The admin's own [modules](/plugins/modules) are built with exactly these, nothing more.

## Build setup

A module builds with three npm packages, as ordinary `devDependencies`: `@letterncms/admin` (the Vite setup and `theme.css`), `@letterncms/sdk` and `@letterncms/ui` (types; the admin provides the code at runtime). [Your first plugin](/plugins/your-first-plugin#build-it) has every file.

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

The theme gives a module the admin's own names, for use instead of raw values: the type scale (`text-2xs` to `text-3xl`, `text-display`), the radii (`rounded-xs` to `rounded-xl`), the colours and shadows, the durations `duration-fast`, `duration-base`, `duration-move` and `duration-slow`, and the layers `z-raised`, `z-drag`, `z-sticky`, `z-bar`, `z-drawer`, `z-overlay` and `z-tooltip`.

`adminModule()` loads `dist/admin.css` too when it's there. A plugin with no stylesheet of its own passes `css: null`.

## Register things

The PHP side declares what the admin lists: sections and sidebar items, Dashboard widgets and commands. The JS side registers the components behind them.

```php
$admin = $this->cms()->admin();
$admin->section('shop', 'Shop', order: 30);
$admin->nav('reviews', ['label' => 'Reviews', 'path' => '/reviews', 'icon' => 'star', 'section' => 'shop', 'permission' => 'reviews.manage']);
$admin->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star', 'column' => 'main', 'permission' => 'reviews.manage']);
$admin->command('reviews-new', ['label' => 'Moderate reviews', 'path' => '/reviews', 'keywords' => ['ratings']]);
```

```typescript
import { registry } from '@letterncms/sdk'
import { lazy } from 'react'

registry.routes.set('/reviews', { path: '/reviews', component: lazy(() => import('./ReviewsScreen')) })
registry.widgets.set('reviews-latest', lazy(() => import('./WidgetLatest')))
registry.fields.set('rating', RatingField)
registry.commands.set('reviews-ask', { label: 'Summarize reviews', perform: () => { /* … */ } })
```

| Registry | For |
|---|---|
| `routes` | Screens. `overlay: true` draws one over the screen it was opened from, which stays open underneath: go there and back with `navigate(path, { overlay: true })`, which doesn't ask about unsaved changes. `private: true` keeps a screen's title and text out of `useScreenContext` readers. |
| `fields` | The editing component for a field type. |
| `panels` | Components in named [slots](#slots). |
| `widgets` | Dashboard widgets (declared in PHP, rendered from here). |
| `components` | Components the assistant can compose: see [Generative UI](/plugins/generative-ui). |
| `commands` | Command palette entries, also offered under `/` in a thread. `acceptsQuery: true` offers the command for any typed text. |
| `entryActions` | Lines in the entry editor's **More Actions** menu (`⋯`). |
| `composer` | What `@` and `/` offer in a thread: see [In the workspace](#in-the-workspace). |
| `icons` | Extra icons by name. |

A later registration under the same key wins, and when its module goes away, what it replaced comes back. A panel, command, entry action or composer source is known by its key: read back from the registry, it has that key as its `id`.

A command declared in PHP takes `label`, `icon`, `group`, `path` or `ability` (with `input`), `keywords` and `permission`.

### Load data before a screen opens

A screen can prepare its data before navigation commits. Add a `load(params, location)` function to the route, and use `prefetchAbility` with the same ability and input as the screen's `useAbility` call:

```typescript
import { prefetchAbility, registry } from '@letterncms/sdk'

registry.routes.set('/reviews/:id', {
  path: '/reviews/:id',
  component: lazy(() => import('./ReviewEditor')),
  load: ({ id }) => prefetchAbility('reviews/get', { id }),
})
```

The admin starts loading code and data on link hover or focus. While an uncached destination loads, the current screen stays visible with the shell's progress indicator; cached results open immediately and stale data refreshes in the background.

- `location.query` holds the destination's query parameters.
- Prepare independent queries with `Promise.all`.
- Loaders must only read data: they can run before a link is followed.
- A later navigation takes precedence over an earlier request.
- Fetch errors still open the destination, so its error and retry UI can handle them.

## The sidebar

The sidebar has two states, both drawn from registered sections and items. The screen on view decides which one shows:

- **The main sidebar**, where people work: every item, section by section, in the order each person put them. The kernel registers the sections `main` (no heading: Dashboard, Analytics, Plugins), `content` (*Content*) and `design` (*Design*). Each collection is an item too (`collection.<handle>`, in the section its definition names), so Templates and Components sit under Design. Everything is there from the start; **More** appears only for what someone unpins.
- **The settings sidebar**, opened with the gear beside your name or `⇧⌘,`: a way back, then what is set up once. The kernel registers `account`, `site` and `system`, shown together without a heading (**Account**, **General**, **Languages**, **Media**, **Email**, **Audit Log**), then `people` (*People*: Users, Roles) and `plugins` (*Plugins*). Each settings page is an item (`settings.<namespace>`). Whatever a plugin puts in a settings section is listed under **Plugins**, by the plugin's name, so no plugin makes a group of its own; that includes settings kept as a **Settings** tab on the plugin's own screen (see [Settings](/plugins/settings#a-settings-tab-on-your-own-screen)). Settings are a place to visit, not something to arrange: these items are never pinned.

```php
$admin->section('shop', 'Shop', order: 30);                       // a section of the main sidebar
$admin->section('billing', 'Billing', order: 15, settings: true); // a section of the settings sidebar
```

| Item key | Meaning |
|---|---|
| `label`, `path`, `icon` | What the row shows and where it goes. Leave out `label` on a plugin's main screen to use the plugin's name. |
| `section` | The section it's listed in: of the main sidebar, or of the settings sidebar when the section is registered with `settings: true`. |
| `order` | Its default place in the section. |
| `pinned` | `true` by default: in everyone's sidebar until they arrange their own. `false` puts it under **More**, for a screen nearly nobody opens. |
| `shortcut` | A key that opens it, shown with the label (e.g. `mod+j`) and listed when someone presses `?`. |
| `permission` | Who may open it. `visible` (a `fn (User $user): bool`) decides per person beyond that. |
| `badge` | A callable returning a count (new form submissions), shown with the label. |

### Or draw it from a view

A widget that shows numbers or a short list needs no React. Give it a `view`: a tree of the same components a [view](/plugins/views) is made of, built in PHP for whoever looks, and Lettern draws it in the widget's frame with its title, loading and errors:

```php
$admin->widget('reviews-score', ['label' => 'Reviews', 'description' => 'How reviews score this month.', 'icon' => 'star', 'permission' => 'reviews.view',
    'action' => ['label' => 'All Reviews', 'to' => '/reviews'],
    'view' => fn (User $user) => ['type' => 'ui/grid', 'props' => ['columns' => 2], 'children' => [
        ['type' => 'ui/stat', 'props' => ['label' => __('Average'), 'value' => Review::thisMonth()->avg('stars')]],
        ['type' => 'ui/stat', 'props' => ['label' => __('Reviews'), 'value' => Review::thisMonth()->count()]],
    ]],
]);
```

The view is the widget's alone: it has no address of its own, and only those who may see the widget may load it.

### How people arrange it

Every row in the sidebar (pinned, under More, settings) and every `SidebarRow` a plugin draws behaves the same:

- A label too long for the row slides to show its end on hover.
- The row's main action (**Unpin**, **Pin to Sidebar**, **Delete Chat**) shows as a button on hover. `Tab` moves from row to row without stopping on it.
- Right-click (long-press on touch) lists everything the row can do, starting with **Open in New Tab**.

Everyone arranges their own sidebar: **Unpin**, **Move Up** and **Move Down** on a row, **Pin to Sidebar** under **More**, drag to reorder, or **Customize Sidebar…** (in every row's menu, at the end of **More** and in `⌘K`) for every item at once. Their arrangement is the `sidebar` preference, and **Reset to Default** in Customize Sidebar gives it up. Until they make one, they see the site's default: **Save as Default** writes it to the `sidebar` value of the `admin` settings, and **Reset Everyone's Default** puts back what modules and plugins registered.

A new item lands in its section after what's there, pinned unless registered `pinned: false`. An item that disappears (a plugin turned off) keeps its place for when it returns. Items under More stay in `⌘K`: pinning is about focus, and the item's `permission` decides access.

A module puts its own item away or back with `events.emit('sidebar.pin', { id, pinned })` (unpinning offers **Undo**); `events.emit('sidebar.customize')` opens Customize Sidebar.

## Dashboard widgets

The Dashboard is what people see first. A plugin registers a widget when it has something worth a glance there: new submissions, the health of a connection, what changed. A plugin with nothing to show registers none, and a widget with nothing to say draws nothing: return `null` from its component (or an empty `ui/stack` from its view) rather than an empty state or a line that repeats a setting.

```php
$admin->widget('reviews-latest', ['label' => 'Latest reviews', 'description' => 'New reviews waiting for a reply.', 'icon' => 'star', 'column' => 'main']);
```

| Key | Meaning |
|---|---|
| `label`, `icon` | The widget's title, and its card in the gallery. |
| `description` | One short sentence for the gallery: what it shows. |
| `column` | Where it lands when added: `main` (wide) or `side` (narrow, the default). |
| `enabled` | On everyone's Dashboard until they rearrange it. Leave it off: only *Recently Edited*, *Site* and *Analytics* start on, so nobody is overwhelmed. People add the rest from the gallery. |
| `permission` | Who may see and add it. |
| `order` | Its place among the others in a column. |
| `assistant` | `false` keeps it out of what an agent answers with: see [Generative UI](/plugins/generative-ui). |
| `view` | Draws it from a [view](/plugins/views) instead of a component: see below. |
| `action` | The link in its header, a `label` in English and where it goes (`to`), for a widget drawn from a view. |

### Draw it

Draw the widget with `Widget` from `@letterncms/ui`. It takes the registered label for its title and handles loading, errors and the empty state, so every widget looks and behaves the same:

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

`WidgetRow`, `Stat`, `Delta`, `Sparkline`, `Meter`, `BarRow` and `compactNumber` are the parts the built-in widgets are made of. The body is a size container: adapt to the column with container variants such as `@md:grid-cols-4`. Give a widget the data it needs through a read-only ability, so agents can use it too.

### How people arrange it

People customize their Dashboard on the Dashboard itself. **Customize** rings each widget where it is: drag widgets within and between the columns, remove them, and add more with each column's **Add Widget**, from the gallery that shows every widget with its description and the plugin it comes from.

The result is their own (the `dashboard` value of their preferences), and **Reset to Default** gives it up. Until they make one, they see the site's default, which admins set with **Save as Default** while customizing: it's the `dashboard` value of the `admin` settings, and the `admin/arrangement` ability returns it for agents. **Reset Everyone's Default** puts back what modules and plugins registered.

## Slots

A slot is a named place in an existing screen where your component appears, like a tab in the entry editor's side panel:

```typescript
registry.panels.set('reviews-summary', { slot: 'entry.sidebar', label: 'Reviews', icon: 'star', component: ReviewsPanel, when: (p) => p.collection.handle === 'products' })
```

`when` decides where it applies, and `order` its place among others. The slot decides the props: `PanelSlots` from `@letterncms/sdk` maps each slot to them, so `when` and the component are typed by the slot you name.

| Slot | Where | Props |
|---|---|---|
| `entry.toolbar` | Entry editor toolbar | `EntryPanelProps`: `entry`, `collection`, `content`, `values`, `title`, `setValue`, `save`, `reload`, `editable`, `can`, `errors` |
| `entry.sidebar` | Tabs in the entry side panel (give `label` and `icon`) | Same |
| `entry.body` | Extra content after the main body, supplied through the workspace footer | Same |
| `entry.editor` | The shared body workspace for the explicitly configured blocks field | `EntryEditorProps` |
| `shell.dock` | A column at the right edge, on every screen. Draw it with `Dock` from `@letterncms/ui` (`open`, `full`, `floating`, `label`): the page stays usable next to it, people can drag it wider, `floating` makes it a card over the page that moves by an element with `data-dock-drag`, `full` grows it over the screen, and small windows get it over the page. The [workspace](/getting-started/workspace)'s thread is one | |
| `sidebar.start` | Rows at the top of the main sidebar, above what's pinned: the workspace's **New Chat**. Draw them with `SidebarRow` | `onNavigate` |
| `workspace.composer` | In the thread's composer, beside **Send**: an [agent](/plugins/agents)'s own controls, such as the assistant's model picker | `ComposerPanelProps`: `thread`, `agent` (the one answering there, its `name` and `label`, or `null`), `state`, `options`, `setOption`, `busy`, `loading` |
| `shell.banner` | A strip above the screen, beside the sidebar, for a notice that concerns the whole admin (the license and update notices) | |
| `topbar.end` | In every screen's top bar, before the screen's own actions: the way back to what's docked | |

**Account** and **Plugins** are [views](/plugins/views): add a section to Account, or a tab to Plugins after Installed, Store and Updates (as the license module adds **Licenses**), with the `view.account` and `view.plugins` filters.

### Entry panels

`EntryPanelProps` is exported by `@letterncms/sdk`. `entry` is `null` until the first save.

- `content: EntryContent` is the complete current working snapshot of `title`, `slug`, `data` and `authorId`. `values` and `title` expose its data and title separately.
- `editable` says whether to allow editing, `can` holds the collection's `create`, `edit`, `publish` and `delete` capabilities, and `errors` the field validation messages.

Panels must respect these capabilities rather than assume everyone can edit or restore a version.

A sidebar panel that edits blueprint fields declares their handles with `fieldHandles`:

```typescript
registry.panels.set('product-reviews', {
  slot: 'entry.sidebar', label: t('Reviews'),
  component: ReviewsPanel, fieldHandles: ['reviews'],
  when: (p) => p.collection.handle === 'products',
})
```

The entry host routes claimed fields to active panels. Unclaimed fields stay in the normal entry UI, including fields from custom sections or a disabled plugin; a field's section name alone doesn't hide it. Declare only the handles the panel actually renders, and show their validation errors there. The shared sidebar always starts with the collection's singular-name details tab, then History, then plugin panels.

### Entry actions and preview

`registry.entryActions.set(id, { label, icon, order, when, perform })` adds a line to the entry editor's **More Actions** menu (`⋯`).

Site owns the single **Preview** dialog, opened from that menu. It previews the complete unsaved snapshot, including before the first save, with `play: true` through the site renderer. A live entry with nothing unpublished offers **View on Site** there instead. To open it from your code, use `events.emit('entry.preview')` from `@letterncms/sdk` instead of adding another preview control or rendering store.

### Screen layout

A screen has two side panels at most, one on each side:

- **On the left**, `ScreenSidebar` from `@letterncms/ui` (`title`, `backTo`, `backLabel`) brings a state of the screen's own to the sidebar, in the same frame as the settings one. It's out or folded away as each person last left it (folded the first time), brought out by the same button and `⌘\`, with its way back beside that button, in or out. It takes the sidebar over at once, without sliding, and a screen can claim it while what fills it still loads. The block workspace's **Outline** does this. With `nested`, the list is a screen's sections instead, set in under the screen's row while the sidebar stays as it is, as the Design System's are; only when that row is under **More** do they take the sidebar over. `useScreenSidebar()` gives its state, `nested` included.
- **On the right** is `InspectorPanel`. A screen that uses it says so with `useScreenContext({ rightEdge: true })`, and a dock floats there instead.

Every screen has one compact top bar: its name after the places that lead to it (`crumbs`) on the left, what it can do on the right, ending with its main action. An editor's own tools go there through the `toolbar` element in `EntryEditorProps`, and keep to a few. A screen about one thing gives `Topbar` a `back` and a `title` instead of `crumbs`. With a `ScreenSidebar`, the sidebar's way back stands in for `back`.

### Tabs and saving

A screen with tabs of its own uses `ScreenTabs` and `useScreenTabs()` from `@letterncms/ui`. When the plugin keeps its settings with the screen, they follow as its last tab, **Settings**: see [Settings](/plugins/settings#a-settings-tab-on-your-own-screen).

A form is saved with `SaveBar` (`dirty`, `saving`, `error`, `onSave`, `onDiscard`): a bar over the bottom of the screen, there only while something changed, with **Discard** and **Save** (`⌘S`), that says what went wrong when saving fails. Leaving with changes asks first, and with changes in more than one form on view, one bar saves or discards them all. A screen shows no Save button of its own.

Something on a screen that someone should see before going on, a problem or a step still to take, is a `Notice` from `@letterncms/ui` (`tone`, `icon`, `title`, its text, an `action` and `onDismiss`): the same one a view's `ui/notice` draws. Anything that failed is a `QueryError` (`title`, `message`, `onRetry`, and `compact` in a panel or a widget), with **Try Again**; never an `EmptyState`, which is for nothing being there yet (`compact` in a widget) beside `NoMatches` for a search that finds nothing. The way into deleting something is `<Button variant="destructive">`, followed by `confirm({ title, confirm, danger: true })`, where `confirm` is the verb on its button.

## Forms are fields

Every form in the admin (sign-in, settings, dialogs, toolbars, search boxes, the block workspace inspector) is a list of field definitions drawn by `Fields`. Raw inputs live only inside field components (`registry.fields`), so a screen never hand-builds a control:

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

A dialog of your own that asks for something is a form too: give `Dialog` an `onSubmit` and it wraps its body in the form, with **Cancel** and a button that says `submitLabel` (Enter submits too). `submitDisabled` keeps the button off until the form can go, `danger` makes it red, and `busy` spins it while the request runs, closing nothing meanwhile.

```typescript
<Dialog open onOpenChange={setOpen} title={t('New Review')} onSubmit={create} submitLabel={t('Create Review')} submitDisabled={!title.trim()} busy={saving}>
  <Fields fields={[{ handle: 'title', type: 'text', label: t('Title'), autofocus: true }]} values={{ title }} onChange={(_, v) => setTitle(v ?? '')} />
</Dialog>
```

Presentation options the core components understand:

| Field | Options |
|---|---|
| Any | `icon`, `size` (`xs` for inspectors, `sm`, `md`, `lg`), `placeholder`, `autofocus`, `autocomplete`, `inputmode`, `mono`, `className` (the field's wrapper) |
| Text | `commit: 'blur'` |
| Select | `display: 'segmented'` (with `block`), option objects with `icon` and `title`, `numeric`; `placeholder` names the option that applies while nothing is chosen (**Browser Language**, **None**) and leads the list, `empty` and `action` say what to do when there are no options |
| Toggle | `display: 'checkbox'` |
| Number | `suffix` and `step` |
| Date | `time: true` and an IANA `timezone`, such as `Europe/Brussels`. The control shows that zone, converts wall times to UTC instants, and rejects missing or ambiguous daylight-saving times with a visible error. |
| In inline rows | `status` (`own` or `inherited`) marks the label: a value set here reads in ink, an inherited one stays muted with a small dot. `reset` makes clicking the label clear the value |

When core can't express a control (a CSS length with tokens, a color with alpha), register a field component and point a field at it with `component`. Core has one of its own, `ease`: an easing curve, picked from `options` (each drawn as its curve; `curve` draws a value that isn't one, such as a design token) or drawn by hand as a cubic-bezier.

### Your own field controls

Custom field controls use `fieldControlId(field)` from `@letterncms/ui` for their control ID and `field.describedBy` for `aria-describedby`. `Fields` supplies these values, so labels, errors and focus targets stay connected. Nested field renderers pass `context.path` with their parent handle (and the row index for repeaters), and keep `context.errors`: a nested `seo.title` must not reuse the document title's ID.

## Lists of records

In a view, a list is `ui/records` (see [Views](/plugins/views)), drawn with `DataView`. In your own React, use `DataView` from `@letterncms/ui` for any overview of records. It gives you the same Table, Grid and Calendar views as content collections (Grid only with `image`, Calendar only with `calendar`), with search, sortable headers, a **Display** menu, saved column and view preferences, loading and error states, and keyboard navigation (`j`/`k`, `x`, Enter and Escape).

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

Give each overview a stable `id`: preferences are saved per account under `overview.<id>`.

### Columns

- The first column identifies the record and stays visible.
- `hiddenByDefault: true` keeps an optional detail available in **Display** without showing it at first.
- Use fixed or fractional column widths, so values can't shift the grid between rows.
- `value` enables sorting of a complete local list.

### Larger lists

| Prop | Use |
|---|---|
| `sort`, `onSort` | For paginated APIs: declare the API field in each sortable column's `sort`, and sort on the server before pagination. |
| `toolbar` | Server search and filters. |
| `selection={{ ids, onSelect }}` | Bulk actions, with `SelectionBar`. |
| `pagination={{ page, pages, total, perPage, onPage }}` | Page controls (hidden in Calendar). |
| `actions` | The same record controls in all three views. |
| `image` | A card preview. Without it there is no Grid. |
| `calendar` | Offer a Calendar, for records that happen on a day (orders, events), not for settings-like lists. |
| `defaultView="grid"` | Start with cards. |

### Dates and the calendar

**Published** and **Updated** are standard columns, added only when the records have those dates: hidden at first outside content entry lists, and available through **Display**. Don't declare them in each screen.

Records implement the SDK's `RecordTimestamps` contract: `publishedAt` and `updatedAt`, as ISO 8601 strings or `null`. Unknown history and dates that don't apply show as `—`. Entries use their publication lifecycle; menus, redirects, collections, globals and forms are published when first saved; media when uploaded. Users, private submissions, audit events and package state have no publication date. Existing records keep unknown publication history as `null`. Saves track update dates on the server; bulk redirect saves keep unchanged rows as they were. Language metadata follows changes to each language's effective settings.

For wrapped rows, pass `dates={(row) => row.record}`. For server-paginated sorting, declare the supported fields with `dateSort={{ published: 'published_at', updated: 'updated_at' }}` alongside `onSort`. Otherwise the shared view sorts dates locally, newest first, with missing dates last. Content entry tables, trees and cards use the same date definitions and formatting.

Every overview uses `OverviewControls` for the same view choices, **Display** menu and **Reset Display** action. Calendar groups records by Published or Updated, chosen in **Display** and saved per overview. Records without the chosen date appear under **No date**. Month navigation and expandable busy days come from `DataCalendar`.

For a paginated source, pass `source={{ ability: 'reviews/list', input: filters, perPage: 100 }}`: the shared loader reads all matching pages through the ability cache, with at most four requests in flight, and handles loading, retries and invalidation. Don't build a screen-specific calendar, or silently render only the current page. Content collections only adapt their date-range filters; they use the same renderer and page loader.

For specialized collections such as trees, compose the same `DataTable`, `TableFrame`, `TableRow`, `TableHeader`, `DataGrid`, `DataCard`, `DataCalendar` and `OverviewControls` primitives. Add missing behavior to the shared primitives rather than introduce another overview pattern.

## Translations

The admin speaks English, Dutch, French and German, and every string you show should too. Write it in English and wrap it in `t()`: the English text is its own key.

```typescript
import { plural, t } from '@letterncms/sdk'

<Button>{t('Send Test Email')}</Button>
toast.success(t('Sent to {email}', { email }))
plural(count, '{count} submission', '{count} submissions')
```

Ship the translations in your package as `lang/<code>.json`: `{ "Send Test Email": "Testmail versturen" }`. The admin merges the core's and every active package's dictionaries for the user's language; a missing string shows in English.

One English word can need two words in another language: the views of a page and the saved views of a list, a phone number and a phone's screen. Because the English text is the key, and one dictionary is read for the core and every package, give the rarer meaning a context after `||`:

```typescript
t('Views')               // a list's saved views: "Ansichten"
t('Views||page views')   // how often a page was opened: "Aufrufe"
```

The context is part of the key, `"Views||page views": "Aufrufe"` in `lang/de.json`, and is never shown: a language without a translation for it, English included, shows `Views`. It works the same in `__('Expired||order')`. Write it in the `t()` or `__()` call, and only where a language needs it. Contexts need Lettern 0.24 or newer.

PHP reads the same files. Use `__('…')` for messages you write. Labels you register (nav items, widgets, settings fields, permissions) are translated for you when they reach the admin.

Each person picks their **Language** in **Account**. **Admin Language** in **Settings → General** sets a default for everyone else, and without one the browser's language is used (English when Lettern doesn't speak it), the sign-in screen included. The core and its plugins come in German as well as English. Dates and numbers follow it (`locale()` from `@letterncms/sdk`).

## In the workspace

The [workspace](/getting-started/workspace)'s thread offers your abilities as commands, and draws what they answer with as [views](/plugins/views). Widgets are available to an agent automatically; for components it can fill in and layouts it composes, see [Generative UI](/plugins/generative-ui). `View`, `Surface` and `WidgetSlot` from `@letterncms/ui` give shared rendering across the Dashboard, the thread and other admin hosts: `<View root={tree} embedded />` draws a view inside something else, and `run` lets that host run its buttons' abilities itself.

### What's on the screen

Something working alongside a screen, like an agent in the thread, can read what that screen is about. Any screen is known by its title and its text. A screen can say more, for as long as a component is mounted:

```typescript
import { useScreenContext } from '@letterncms/sdk'

useScreenContext({
  kind: 'order',
  data: () => ({ id: order.id, status: order.status }),  // read only when it's needed; takes the place of the screen's text
  items: line ? [{ id: line.id, label: line.title, icon: 'cart', read: () => line }] : [],  // what else it offers, like the block selected in the builder
  flush: () => save(),                                   // bring it up to date before someone reads or changes it
})
```

The entry editor gives the entry and saves first; the block workspace offers the selected blocks. To read it, use `useScreen()`, or `screenContext.get()` and `screenText(limit)`. A screen with something to keep to itself sets `private: true` on its route. After changing content from outside a screen, `events.emit('content.changed')` makes an open entry editor show the new version, unless it has unsaved edits.

### @ and / in a thread

`/` offers commands: making things, places to go, settings pages, the commands of `⌘K` and every ability the person may run. `@` attaches context to a message, and is there only while an agent answers: a command or a search carries nothing. Everything a message carries is a `ContextItem`: an `id`, a `label`, optionally an `icon`, a `kind`, a `to` (an admin path to open it at) and `read` (what it says, called when a message goes out). The page on view, what a screen offers and what's picked with `@` are all the same thing, shown as the same chip.

To offer your own under `@` or `/`, register a source. It searches by what's typed after the trigger:

```typescript
import { registry, run, t } from '@letterncms/sdk'

registry.composer.set('orders', {
  trigger: '@', label: t('Orders'), order: 30,
  search: async (query) => (await run('orders/search', { query, limit: 5 })).map((order) => ({
    id: `order:${order.id}`, kind: 'order', label: order.number, detail: order.customer, icon: 'cart',
    to: `/shop/orders/${order.id}`,
    read: () => run('orders/get', { id: order.id }),
  })),
})
```

Reading through `run` keeps your ability's permission check. What picking a line does follows from what it has: `perform` runs it, `insert` writes text in the message, `skill` asks for that skill, `command` runs an ability in the thread, and without any of those it's attached. `group` gives a line a heading of its own.

A `command` names the `ability`, the `input` already chosen and the ability's input `schema`: what it requires and isn't chosen is asked for in the composer, generated from the schema (a choice is a select, yes or no a switch, a list of words tags), with `required: true` asking only for that. `load` asks with fields of your own and what they hold now instead (only what changed is sent), `into` puts the answers under one key, and `confirm` names the button. Field choices take their words from the schema's `x-labels` (see [Asking for input](/getting-started/workspace#asking-for-input)):

```typescript
{ id: 'new-review', label: t('New Review'), icon: 'plus', command: { ability: 'reviews/create', input: { status: 'draft' }, schema, required: true } }
{ id: 'review-settings', label: t('Review Settings'), command: { ability: 'settings/update', input: { namespace: 'reviews' }, into: 'values', load: () => run('settings/get', { namespace: 'reviews' }) } }
```

### Skills

Skills are registered on the server, and every agent gets them: `/` in a thread while the assistant answers there, prompts over MCP.

```php
cms()->skills()->register('order-summary', [
    'label' => 'Summarize Orders',
    'description' => 'What sold this week, and what stands out.',
    'icon' => 'cart',
    'prompt' => 'Summarize the orders of {period}. Lead with what stands out.',
    'arguments' => [['name' => 'period', 'description' => 'Which days', 'required' => true]],
    'permission' => 'shop.view',
]);
```

In a thread, the person's message gives the arguments.

## Block workspace

The `entry.editor` slot supplies the shared block workspace. The content host mounts it only when the collection explicitly names a `body` field whose type is `blocks`. It doesn't infer a body from field order or choose an editor based on a collection flag. Collections without a blocks body use the normal field form. A `markdown` field stays a raw text and code field, not another content workspace.

```typescript
registry.panels.set('blocks-editor', {
  slot: 'entry.editor',
  label: 'Blocks',
  icon: 'blocks',
  component: lazy(() => import('./BlocksWorkspace').then((m) => ({ default: m.BlocksWorkspace }))),
  when: (p) => p.bodyField.type === 'blocks',
})
```

The host owns working content, saving, publishing, permissions and entry details. `EntryEditorProps` extends `EntryPanelProps`:

| Prop | Holds |
|---|---|
| `entry`, `collection`, `values`, `title` | The entry and its working values. |
| `content` | The complete working snapshot inherited from `EntryPanelProps`: `title`, `slug`, `data` and `authorId`. |
| `bodyField` | The explicitly configured main-content field. |
| `setValue(handle, value)`, `setTitle(title)` | Change the working copy through the host. |
| `save()`, `reload()` | Save now; reload from the server. Save failures reject, so extensions can handle them. |
| `editable`, `can`, `errors` | Editing access, action capabilities and field validation errors. |
| `footer` | The `entry.body` plugin panels that apply; render after the live surface in a bounded scrolling area. |
| `sidebar` | Host-rendered entry details, History and plugin tabs. |
| `sidebarOpen`, `setSidebarOpen(open)` | Sidebar visibility and its setter. |

The workspace renders the supplied footer and sidebar rather than recreating metadata controls or tab ordering. The host keeps the entry title and collection fields in Details, with claimed fields in their plugin panels.

The body uses the existing site renderer, with rendered block IDs bridged to the shared store. A template's exact `entry.title` text binding can also edit the title inline through `setTitle`; both controls use the same working snapshot. Sample titles while editing templates or components stay read-only.

Selecting a block opens the shared Content, Design and Interact inspector; returning to entry details restores the host sidebar. Outline and insertion between rendered sections use the same complete catalog of compatible blocks. Rendered components, sample content and repeated items keep their source provenance rather than becoming editable nodes in the owning body. Preview doesn't own a second editing store.

## Share a module

A plugin can expose its module to others through the import map. The forms plugin builds on the block editor this way:

```php
$this->adminModule(import: '@acme/reviews');
```

Other modules then `import { … } from '@acme/reviews'` and list it in `externals` of `cmsAdminModule`.
