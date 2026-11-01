---
id: 01m5wmrf5ab8t838727bwfd1pt
title: Fields
position: 1
group: 'Model'
description: Fields describe what an entry holds. Every field has a type, and every type validates, stores and renders its value.
---
A field is a small YAML object in a collection's `fields`, a fieldset, a global set, a block or a settings group — the same format everywhere.

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

## Common options

| Option | Meaning |
|---|---|
| `handle` | The key the value is stored under. Lowercase letters, numbers and underscores. |
| `type` | One of the [field types](/content/field-types). |
| `label`, `instructions` | Shown in the editor. |
| `required` | Must be filled before publishing. Drafts can be saved incomplete. |
| `default` | Value for new entries. |
| `width` | `full`, `half`, `third` or `two-thirds` of the form. |
| `section` | `main` (the content form), `sidebar` (entry details) or a custom section. An active plugin panel can claim the fields it edits; otherwise they remain available in the normal entry UI. |
| `if` | Show the field only when other fields match: `if: { type: video }` or `if: { type: [video, audio] }`. |
| `localizable` | `false` keeps one value for all languages. |

Everything else is an option of the field type, like `min` above or `options` for a select.

## Nested fields

`group` and `repeater` fields hold their own `fields`: a group stores one object, a repeater a list of them. Sub-fields use the same format and can nest again (up to five levels).

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

In **Collections**, open a group or repeater field and use **Add sub-field** to build its fields with the same editor — drag to reorder, open a sub-field to configure it. When a collection or global set is saved, Lettern checks every level: handles must be valid and unique among their siblings, and every type must exist.

## Validation

Each type turns its value into a JSON schema; Lettern validates supplied values on save — whether it comes from the admin, an import, the API or an agent. Drafts may omit required content; publishing checks the complete entry. Errors name the field and say what is wrong, so agents can correct themselves.

## On the page

Connect any block to a field in the block workspace: select a heading in a template, open **Content**, click the database icon next to its text and choose **Page fields → Subtitle**. The path is `entry.<handle>`:

```json
{ "type": "heading", "props": { "level": "1" }, "bind": { "text": "entry.title" } }
{ "type": "paragraph", "bind": { "text": "entry.date|date:j F Y" } }
{ "type": "image", "bind": { "image": "entry.hero", "visible": "entry.hero" } }
```

Values come out ready to use: dates format with `|date`, media fields give images, entry relations give entries (for example, `entry.company.title` for a single Company relation), and rich text keeps its HTML with `|raw`. A collection's body field renders in its template's **Page content** block. See [Data and Repeat](/design/data).

In PHP (a plugin's block or data source), the same values come from `Cms\Site\Rendering\AugmentedEntry`: `$entry->title`, `$entry->author`, `$entry->hero`, and `$entry->raw('field')` for the stored value.

`entry.author` exposes the credited person as `id`, `name`, `initials` and `avatar`, or `null` when no person can be resolved. Bind a byline to `entry.author.name`. Published output uses the published credit; rendered preview includes the current unsaved credit.
