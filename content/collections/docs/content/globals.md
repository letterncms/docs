---
id: 01m5wmrf5hn71fkqbrdzf3ah04
title: Globals
position: 5
description: Things that appear all over your site, like your phone number or a footer note, kept in one place.
---
Some details appear on many pages: your phone number, opening hours, social links, a line in the footer. Globals keep each of them in one place. Change it once, and every page that shows it follows.

::: html {"props":{"html":"<figure class=\"card\" data-variant=\"flat\" role=\"img\" aria-label=\"A global set called Contact holds an email address and a phone number. The header, the footer and the contact page all show the same phone number.\"><div class=\"cluster\" data-gap=\"sm\"><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><b class=\"text-label\">Contact</b><span class=\"badge\">Email</span><span class=\"badge\">Phone</span></div><b class=\"text-label\">Global set</b><figcaption>Edited in one place</figcaption></figure><div class=\"cluster\" data-gap=\"sm\"><span class=\"text-lead\">→</span><figure class=\"stack\" data-gap=\"2xs\"><div class=\"card\" data-variant=\"raised\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Header</span><span class=\"badge\">+31 20 123 4567</span></span><hr class=\"divider\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Footer</span><span class=\"badge\">+31 20 123 4567</span></span><hr class=\"divider\"><span class=\"cluster\" data-gap=\"xs\"><span class=\"text-caption\">Contact page</span><span class=\"badge\">+31 20 123 4567</span></span></div><b class=\"text-label\">Your pages</b><figcaption>Always the same, always current</figcaption></figure></div></div></figure>"}}
:::

Globals come in **global sets**: a group of fields that belong together, like *Contact* or *Footer*, with one set of values for the whole site.

## Create a global set

1. Open **Globals**, under **Content** in the sidebar.
2. Press **New Global Set**, give it a name like *Contact*, and press **Create**.
3. The set opens on its fields, with one text field to start. Add the fields you need, like an email address and a phone number, and press **Save** in the bar at the bottom.

Fields work just like they do in collections. See [Fields](/content/fields).

## Fill in the values

Open the set, fill in its fields and press **Save**, or `⌘S`. Pages that show these values are updated for you.

To change the set's fields later, press **Edit Fields** at the top. **Delete Global Set** is at the end of that page.

## Show a value on your pages

1. Select a block, like a paragraph in your footer, and open **Content**.
2. Point at its **Text** and press the database icon beside the label, **Connect to Data**.
3. Under **Globals**, choose the set, then add the field's handle, so it reads like `globals.contact.phone`.

The starter site's footer shows the **Tagline** of its **Footer** set this way.

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
