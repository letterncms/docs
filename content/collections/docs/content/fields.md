---
id: 01m5wmrf5ab8t838727bwfd1pt
title: Fields
position: 1
description: The questions an entry's form asks, like a price, a date or a photo, and how to show the answers on your pages.
---
Fields are the parts an entry is made of: a price, a description, a photo. Each field has a **type**, which decides what the form shows, what counts as a valid answer, and how the value appears on your site.

Collections and global sets use fields in exactly the same way, so once you've added one, you know how to add them all.

![The Dishes collection's fields: price, course, description, allergens, photo and whether it's on the menu.](/media/screens/collection.webp)

## Add a field

1. Open **Settings → Collections** and pick a collection. For a global set, open it and press **Edit Fields**.
2. On the **Fields** tab, press **Add Field** and pick a type. Type to search the list.
3. Give the field a **Label** (what people see) and a **Handle** (the name it's stored under, like `price`).
4. Press **Save**.

Drag fields to change their order in the form. Use **Duplicate** to copy a field with its settings, or **Remove Field** to take it out.

## Pick a type

A few types cover most sites:

| Type | For |
|---|---|
| **Text**, **Textarea** | A name, a short line, a paragraph |
| **Rich text** | Formatted text with bold, links and lists |
| **Number**, **Date**, **Toggle** | A price, an event date, a yes or no |
| **Select** | One choice from a list, like *Starter*, *Main* or *Dessert* |
| **Media** | Images, documents or videos from the [media library](/content/media) |
| **Entries** | A link to other entries, like a post's author or related products |
| **Group**, **Repeater** | A set of fields together, once or as a list (see below) |

There are more, like **Color**, **Link**, **Tags** and **Blocks**. See [Field types](/reference/field-types) for every one and its options.

## Set it up

Open a field to change its settings. These work for every type:

| Setting | What it does |
|---|---|
| **Label** | The name on the form. |
| **Handle** | The name the value is stored under: lowercase letters, numbers and underscores. Changing it later leaves the values already saved behind. |
| **Instructions** | A hint shown under the field, like *In euros, without VAT.* |
| **Required** | It must be filled in before publishing. Drafts can still be saved without it. |
| **Show as Property** | Moves the field out of the form into the entry's details panel on the right. Good for things like tags. |
| **Width** | Full, half or a third of the form, so short fields can sit side by side. |

Below these are the options of the type itself, such as **Minimum** and **Maximum** for a number, or the **Options** of a select.

## Fields inside fields

A **Group** holds a few fields that belong together, like an address. A **Repeater** holds a list of them, like the members of a team, each with a name and a photo.

Open a group or repeater and press **Add Sub-Field** to build its fields, with the same editor. Sub-fields can hold fields of their own, up to five levels deep.

## Every value is checked

When an entry is saved, Lettern checks each value against its field, whether it comes from the admin, an import, the API or an AI agent. Errors name the field and say what's wrong. Drafts may leave required fields empty; publishing checks the whole entry.

## Show a field on the page

Connect any block to a field, and it shows that entry's value. For example, to show a subtitle in a template:

1. Select the heading in the template and open **Content**.
2. Click the database icon next to its text.
3. Choose **Page Fields → Subtitle**.

Each entry now shows its own subtitle there. See [Showing content](/design/data) for lists, images and more.

## For developers

### The field format

A field is a small YAML object, with the same format in a collection's `fields`, a fieldset, a global set, a block or a settings group:

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
| `required` | Must be filled before publishing. Drafts can be saved incomplete. |
| `default` | Value for new entries. |
| `width` | `full`, `half`, `third` or `two-thirds` of the form. |
| `section` | `main` (the content form), `sidebar` (entry details, what **Show as Property** sets) or a custom section. An active plugin panel can claim the fields it edits; otherwise they stay in the normal entry form. |
| `if` | Show the field only when other fields match: `if: { type: video }` or `if: { type: [video, audio] }`. |
| `localizable` | `false` keeps one value for all languages. |

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

When a collection or global set is saved, Lettern checks every level: handles must be valid and unique among their siblings, and every type must exist.

### Validation

Each type turns its value into a JSON schema, and Lettern validates every supplied value on save. Error messages name the field and say what is wrong, so agents can correct themselves.

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

In a plugin's block or data source, the same values come from `Cms\Site\Rendering\AugmentedEntry`: `$entry->title`, `$entry->author`, `$entry->hero`, and `$entry->raw('field')` for the stored value.
