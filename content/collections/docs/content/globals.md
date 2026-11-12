---
id: 01m5wmrf5hn71fkqbrdzf3ah04
title: Global Sets
position: 5
description: Things that appear all over your site, like your phone number or a footer note, kept in one place.
---
Some details appear on many pages: your phone number, opening hours, social links, a line in the footer. Global sets keep each of them in one place. Change it once, and every page that shows it follows.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A global set called Contact holds an email address and a phone number. The header, the footer and the contact page all show the same phone number.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Contact</b><span class=\"docs-card__field\">Email</span><span class=\"docs-card__field\">Phone</span></div><b>Global set</b><small>Edited in one place</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Header</span><em>+31 20 123 4567</em></div><div class=\"docs-card docs-card--row\"><span>Footer</span><em>+31 20 123 4567</em></div><div class=\"docs-card docs-card--row\"><span>Contact page</span><em>+31 20 123 4567</em></div></div><b>Your pages</b><small>Always the same, always current</small></div></div></figure>"}}
:::

A **global set** is a group of fields that belong together, like *Contact* or *Footer*, with one set of values for the whole site.

## Create a global set

1. Open **Global Sets**, under **Content** in the sidebar.
2. Press **New Global Set**, give it a name like *Contact*, and press **Create Global Set**.
3. The set opens on its fields, with one text field to start. Add the fields you need, like an email address and a phone number, and press **Save** in the bar at the bottom.

Fields work just like they do in collections. See [Fields](/content/fields).

## Fill in the values

Open the set, fill in its fields and press **Save**, or `⌘S`. Pages that show these values are updated for you.

To change the set's fields later, press **Edit Fields** at the top. Its name and icon are on the **Settings** tab there, with **Delete Global Set** at the end.

## Show a value on your pages

1. Select a block, like a paragraph in your footer, and open **Content**.
2. Point at its **Text** and press the database icon beside the label, **Connect to Data**.
3. Under **Global Sets**, choose the set, then add the field's handle, so it reads like `globals.contact.phone`.

The footer of a new site, from the kit Minimal, shows the **Tagline** of its **Footer** set this way.

## In other languages

On a site with several [languages](/content/languages), a global set holds a value for each one. Each language has a tab at the top of the set: open one to fill in its translation. Anything you don't translate shows the default language's value.

This is also how the words in your templates and components get translated: put them in a global set, and bind the blocks to it.

## For developers

### The global set file

Each set is stored as YAML in `content/globals/`, with its fields, its values and the values per language:

```yaml
# content/globals/contact.yaml
title: Contact
icon: phone
fields:
  - handle: email
    type: email
  - handle: phone
    type: text
data:
  email: hello@acme.com
  phone: '+31 20 123 4567'
locales:
  de:
    phone: '+49 30 123 4567'
```

Add `api: true` to make a set's values public at `GET /api/v1/globals/<handle>`. See [REST API](/agents/rest-api).

### Bindings

Connect any block to a global value with the path `globals.<set>.<field>`. Inside a longer text, wrap it in braces:

```json
{ "type": "link", "props": { "label": "Email us" }, "bind": { "url": "mailto:{globals.contact.email}" } }
{ "type": "paragraph", "bind": { "text": "globals.contact.phone", "visible": "globals.contact.phone" } }
```

In PHP, read one with `cms_global('contact.phone')`.

### Rebuilds

Pages that use globals are rebuilt when a set changes, as long as **Rebuild Automatically on Publish** is on under **Settings → General** (it is by default).
