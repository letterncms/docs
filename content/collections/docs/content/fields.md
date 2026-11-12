---
id: 01m5wmrf5ab8t838727bwfd1pt
title: Fields
position: 1
description: The questions an entry's form asks, like a price, a date or a photo, and how to show the answers on your pages.
---
Fields are the parts an entry is made of: a price, a description, a photo. Each field has a **type**, which decides what the form shows, what counts as a valid answer, and how the value appears on your site.

Collections and globals use fields in exactly the same way, so once you've added one, you know how to add them all.

![The Dishes collection's fields: price, course, description, allergens, photo and whether it's on the menu.](/media/screens/collection.webp)

## Add a field

1. Open **Collections**, under **Design** in the sidebar, and pick a collection. For a global, open it and press **Edit Fields**.
2. On the **Fields** tab, press **Add Field** and pick a type. Type to search the list.
3. Give the field a **Label** (what people see) and a **Handle** (the name it's stored under, like `price`).
4. Press **Save** in the bar at the bottom, or `⌘S`.

Drag fields to change their order in the form. Use **Duplicate** to copy a field with its settings, or **Remove Field** to take it out.

## Pick a type

A few types cover most sites:

| Type | For |
|---|---|
| **Text**, **Textarea** | A name, a short line, a paragraph |
| **Rich Text** | Formatted text with bold, links and lists |
| **Number**, **Date**, **Toggle** | A price, an event date, a yes or no |
| **Select** | One choice from a list, like *Starter*, *Main* or *Dessert* |
| **Media** | Images, documents or videos from the [media library](/content/media) |
| **Entries** | A link to other entries, like a post's author or related products |
| **Terms** | Topics or categories from a [taxonomy](/content/taxonomies) |
| **File** | Documents, audio or video from the media library: anything but images |
| **Link** | A link to a page, an address, an email, a phone number or a file, with its label |
| **Date Range**, **Time** | When an event starts and ends, when the doors open |
| **Range** | A number on a slider, like a difficulty from 1 to 5 |
| **Table** | Rows and columns of text, like a schedule or a price list |
| **Location** | A place: latitude, longitude and an address |
| **Group**, **Repeater**, **Matrix** | A set of fields together: once, as a list, or as a list of rows of several kinds (see below) |

There are more, like **Color**, **URL**, **Tags** and **Blocks**. See [Field types](/reference/field-types) for every one and its options.

## Set it up

Open a field to change its settings. These work for every type:

| Setting | What it does |
|---|---|
| **Label** | The name on the form. |
| **Handle** | The name the value is stored under: lowercase letters, numbers and underscores. Changing it later leaves the values already saved behind. |
| **Instructions** | A hint shown under the field, like *In euros, without VAT.* |
| **Required** | It must be filled in before publishing. Drafts can still be saved without it. |
| **Show as Property** | Moves the field out of the form into the entry's details panel on the right. Good for things like tags. |
| **Use as Body** | On a blocks, Markdown or rich text field of a collection: makes it the entry's main content. See [The body](/content/collections#the-body). |
| **Width** | Full, half or a third of the form, so short fields can sit side by side. |

Below these are the options of the type itself, such as **Minimum** and **Maximum** for a number, or the **Options** of a select.

## Show a field only sometimes

A field can depend on the fields beside it: a *Stream address* that only shows for online events, a *Seats* number that is only required for workshops.

Open the field and, under **Conditions**, press **Add Condition**. A condition reads as a sentence: **Show** when *Kind* is *Workshop*, or **Require** when *Featured* is **On**. **Show** hides the field until the condition holds; **Require** leaves it on view and makes it required then. A required field that only shows under a condition is required only while it shows.

Rename a field and the conditions that name it follow. Remove it and they go with it.

## Fields inside fields

A **Group** holds a few fields that belong together, like an address. A **Repeater** holds a list of them, like the members of a team, each with a name and a photo.

Open a group or repeater and press **Add Sub-Field** to build its fields, with the same editor. Sub-fields can hold fields of their own, up to five levels deep.

A **Matrix** is a list whose rows come in kinds, each kind with fields of its own: a page made of quotes, fact lists and galleries, in any order. Open the matrix field and press **Add Row Type** for each kind: it has a name, a handle and fields of its own, built with the same editor. In an entry, **Add Row** offers the kinds, each row opens on the fields of its kind, and rows are dragged to reorder. **Remove Row Type** asks first and says how many rows were made with it: they keep their values, without those fields.

## Every value is checked

When an entry is saved, Lettern checks each value against its field, whether it comes from the admin, an import, the API or an AI agent. Errors name the field and say what's wrong. Drafts may leave required fields empty; publishing checks the whole entry.

Fields that point at something are checked too. An **Entries**, **Users**, **Media** or **File** field only takes what exists, an Entries field only entries of the collections it allows, and a Media or File field only the kinds of file it allows. What an entry already pointed at stays, so content that names something since deleted can still be saved.

## Show a field on the page

Connect any block to a field, and it shows that entry's value. For example, to show a subtitle in a template:

1. Select the heading in the template and open **Content**.
2. Point at its **Text** and press the database icon beside the label, **Connect to Data**.
3. Choose **Page Fields → Subtitle**.

Each entry now shows its own subtitle there. See [Showing content](/design/data) for lists, images and more.

## For developers

### The field format

A field is a small YAML object, with the same format in a collection's `fields`, a fieldset, a global, a block or a settings group:

```yaml
- handle: price
  type: number
  label: Price
  instructions: In euros, without VAT.
  required: true
  min: 0
  width: half
  section: sidebar
```

| Option | Meaning |
|---|---|
| `handle` | The key the value is stored under. Lowercase letters, numbers and underscores. |
| `type` | One of the [field types](/reference/field-types). |
| `label`, `instructions` | Shown in the editor. |
| `about` | What the field is for, said only to agents: in the site's [schema files](/agents#the-content-model-as-json-schema-files), the API and MCP. They read `instructions` when there are any, else `about`, else the label. |
| `required` | Must be filled before publishing. Drafts can be saved incomplete. |
| `default` | Value for new entries. |
| `width` | `full`, `half`, `third` or `two-thirds` of the form. |
| `section` | `main` (the content form), `sidebar` (entry details, what **Show as Property** sets) or a custom section. An active plugin panel can claim the fields it edits; otherwise they stay in the normal entry form. |
| `if` | Show the field only while the fields beside it hold these values: `if: { kind: video }`, or `if: { kind: [video, audio], featured: true }`. A `required` field with a condition is required only then. |
| `required_if` | Leaves the field on view and requires it under a condition: `required_if: { kind: workshop }`. |
| `body` | `true` on one `blocks`, `markdown` or `richtext` field of a collection's blueprint: the entry's main content. See [The body](/content/collections#the-body). |
| `localizable` | `false` keeps one value for all languages: see [Languages](/content/languages#fields-shared-across-languages). |

Everything else is an option of the field type, like `min` above or `options` for a select.

### Nested fields

`group` and `repeater` fields hold their own `fields`: a group stores one object, a repeater a list of them. Sub-fields use the same format and can nest again, up to five levels.

```yaml
- handle: team
  type: repeater
  label: Team
  max: 12
  fields:
    - { handle: name, type: text, required: true }
    - handle: social
      type: group
      fields:
        - { handle: url, type: url, label: Link }
```

When a collection or global is saved, Lettern checks every level: handles must be valid and unique among their siblings, and every type must exist.

### Conditions

`if` and `required_if` are what **Conditions** in the fields editor writes. They work in collections, globals and every other blueprint, as they do in a block's fields. A condition names fields beside the field it is on, each with a value or a list of values, and holds when every one matches. One that names a field that isn't there, or conditions that come back to their own field, are refused when the definition is saved, in the editor and by `collections/save`:

```json
{ "error": { "type": "invalid_input", "message": "The condition of a must name fields beside it, each with a value or a list of values." } }
```

Publishing checks conditions, and the collection's JSON Schema says them, as `allOf` with `if` and `then`, in `collections/schema`.

### Matrix

A `matrix` field lists its kinds under `types`, each with a `handle`, a `label` and `fields`. `max` limits the rows.

```yaml
- handle: sections
  type: matrix
  label: Sections
  types:
    - handle: quote
      label: Quote
      fields:
        - { handle: text, type: textarea, required: true }
        - { handle: by, type: text }
    - handle: facts
      label: Facts
      fields:
        - { handle: items, type: tags }
```

A row is its fields' values and `type`, the handle of its kind:

```json
[
  { "type": "quote", "text": "Type is a voice.", "by": "Ada" },
  { "type": "facts", "items": ["serif", "grotesk"] }
]
```

Each row is checked against the fields of its kind, with errors that name them: `data.sections.0.text`, `data.sections.1.type`.

### What each type stores

The [field types reference](/reference/field-types) lists every type with its options. These are the values of the types that hold more than a text or a number, as `entries/create`, `entries/update` and the content API take and give them:

| Type | Value | Options |
|---|---|---|
| `link` | `{"type": "entry", "value": "<entry id>", "label": "Read more", "new_tab": true}`. `type` is `entry`, `url`, `email`, `phone` or `media` (a file's id); `label` and `new_tab` are optional. A string is read as a link: `https://…`, `/path`, `entry:<id>`, `mailto:…`, `tel:…` | `types` limits the kinds, `collections` the entries |
| `date-range` | `{"start": "2026-12-01", "end": "2026-12-03"}`. The end is not before the start. A draft may hold one of the two | `time: true` for moments: `"2026-12-01T18:00:00+01:00"` |
| `time` | `"17:30"`, on a 24-hour clock | `seconds: true` for `"17:30:00"` |
| `range` | A number between `min` and `max`. A value between two steps moves to the nearest | `min` (0), `max` (100), `step` (1) |
| `table` | `[["Time", "What"], ["18:00", "Welcome"]]`: rows of text cells. Every row is made as wide as the widest | `header` (on by default): the first row is the header. `max` rows |
| `geo` | `{"lat": 51.0543, "lng": 3.7174, "address": "Korenmarkt, Gent"}` in decimal degrees. The address is text and optional; no map service is called | |
| `file` | `["<file id>"]`: ids of files that are not images | `max`, and `accept`, such as `application/pdf, video/*` |
| `terms` | `["<term id>"]`. A term's slug or title is taken too, and stored as its id | `taxonomy` (required), `max` |
| `matrix` | A list of rows, each with its `type` | `types`, `max` |

Stored exactly as sent, this entry:

```json
{
  "signup": "mailto:Hello@Example.com",
  "when": { "start": "2026-12-01T18:00:00+01:00", "end": "2026-12-01T21:00:00+01:00" },
  "doors": "17:30",
  "level": 2.4,
  "schedule": [["Time", "What"], ["18:00", "Welcome"], ["18:15", "Letters", "extra"]],
  "place": { "lat": 51.0543, "lng": 3.7174, "address": "Korenmarkt, Gent" },
  "topics": ["news", "Design"]
}
```

comes back as:

```json
{
  "signup": { "type": "email", "value": "hello@example.com" },
  "when": { "start": "2026-12-01T18:00:00+01:00", "end": "2026-12-01T21:00:00+01:00" },
  "doors": "17:30",
  "level": 2,
  "schedule": [["Time", "What", ""], ["18:00", "Welcome", ""], ["18:15", "Letters", "extra"]],
  "place": { "lat": 51.0543, "lng": 3.7174, "address": "Korenmarkt, Gent" },
  "topics": ["01m75fkz8xmta2n3djr5xn4fee", "01m75fkzmtc82pz2cgqwx1pnp4"]
}
```

In templates and bindings the values come out ready to use:

| Type | A template gets |
|---|---|
| `link` | `url` (the page's address, `mailto:`, `tel:` or the file) and a `label` that falls back to the page's title or the file's name, with `type`, `value` and `new_tab`. `url` is empty when the page is not published |
| `date-range` | `start` and `end` as dates: `entry.when.start\|date:j F` |
| `table` | `header` (the first row) and `rows` (the others) |
| `file` | `{id, url, name, filename, extension, mime, kind, size}` for each file; one object, not a list, with `max: 1` |

### Relations

An `entries`, `users`, `media`, `file` or `terms` field, and a `link` to an entry or a file, only take ids that exist. A write that names something else is refused with the path of the id, in a dry run too:

```json
{
  "error": {
    "type": "invalid_input",
    "message": "Invalid input: data.signup.value: This entry does not exist.; data.when.end: Must not be before the start.; data.topics.0: There is no term “nope” in this language.; data.host.0: This entry does not exist.",
    "details": {
      "data.signup.value": "This entry does not exist.",
      "data.when.end": "Must not be before the start.",
      "data.topics.0": "There is no term “nope” in this language.",
      "data.host.0": "This entry does not exist."
    }
  }
}
```

Entry ids are stored in lower case. To find what points at an entry, see [Reverse relations](/content/entries#reverse-relations).

### Validation

Each type turns its value into a JSON schema, and Lettern validates every supplied value on save. Error messages name the field by its path in the input and say what is wrong, so agents can correct themselves:

```json
{
  "details": {
    "data.doors": "Has an invalid format.",
    "data.level": "Must be at most 5.",
    "data.place.lat": "Must be at most 90.",
    "data.sections.0.text": "Is required.",
    "data.sections.1.type": "Must be one of: \"quote\", \"facts\".",
    "data.seats": "Expected integer, got null."
  }
}
```

A field type of a plugin can also check its own definition when a blueprint is saved, with `FieldType::validateDefinition()`.

### Bindings

A block binds to a field with the path `entry.<handle>`:

```json
{ "type": "heading", "props": { "level": "1" }, "bind": { "text": "entry.title" } }
{ "type": "paragraph", "bind": { "text": "entry.date|date:j F Y" } }
{ "type": "image", "bind": { "image": "entry.hero", "visible": "entry.hero" } }
```

Values come out ready to use: dates format with `|date`, media fields give images, entry relations give entries (for example `entry.company.title` for a single Company relation), and rich text keeps its HTML with `|raw`. A collection's body field renders in its template's **Page content** block.

`entry.author` is the credited person, with `id`, `name`, `initials` and `avatar`, or `null` when nobody can be resolved. Bind a byline to `entry.author.name`. Published pages use the published credit; the preview includes the current unsaved one.

### In PHP

In a plugin's block or data source, the same values come from `Cms\Modules\Site\Rendering\AugmentedEntry`: `$entry->title`, `$entry->author`, `$entry->hero`, and `$entry->raw('field')` for the stored value.
