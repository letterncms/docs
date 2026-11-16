---
id: 01m5wmrf5hn71fkqbrdzf3ah04
title: Globals
position: 5
description: Things that appear all over your site, like your phone number or a footer note, kept in one place.
---
Some details appear on many pages: your phone number, opening hours, social links, a line in the footer. Globals keep each of them in one place. Change it once, and every page that shows it follows.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"A global called Contact holds an email address and a phone number. The header, the footer and the contact page all show the same phone number.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Contact</b><span class=\"docs-card__field\">Email</span><span class=\"docs-card__field\">Phone</span></div><b>Global</b><small>Edited in one place</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-stack\"><div class=\"docs-card docs-card--row\"><span>Header</span><em>+31 20 123 4567</em></div><div class=\"docs-card docs-card--row\"><span>Footer</span><em>+31 20 123 4567</em></div><div class=\"docs-card docs-card--row\"><span>Contact page</span><em>+31 20 123 4567</em></div></div><b>Your pages</b><small>Always the same, always current</small></div></div></figure>"}}
:::

A **global** is a group of fields that belong together, like *Contact* or *Footer*, with one set of values for the whole site. It is a [collection](/content/collections) of the type **Global** that holds a single entry: its values. So they have drafts, publishing, history, comments and translations, like any page.

![The values of a global, in a form of their own.](/media/screens/content-globals.webp)

## Create a global

1. Open **Structure** in the sidebar, then **Globals**, and press **New Global**.
2. Give it a name, like *Contact*, and press **Create Global**.
3. The global opens on its fields, with one text field to start. Add the fields you need, like an email address and a phone number, and press **Save** in the bar at the bottom.

Fields work just like they do in collections. See [Fields](/content/fields). The global's **Settings** tab holds its name and icon, with **Delete Collection** at the end.

## Fill in the values

Open **Content** in the sidebar: your globals are listed under **Globals**. Choose one and its values open, in a form like an entry's without a title. Fill in the fields and press **Publish**. Until then the values are a draft, and the site keeps showing what was published before.

After that, change a value and press **Publish Changes**. Pages that show it are rebuilt for you. **History**, in the details beside the form, goes back to an earlier version, as for any [entry](/content/entries#go-back-to-an-earlier-version).

A global has one set of values: making a second entry in it is refused.

## Show a value on your pages

1. Select a block, like a paragraph in your footer, and open **Content**.
2. Point at its **Text** and press the database icon beside the label, **Connect to Data**.
3. Under **Globals**, choose the global, then add the field's handle, so it reads like `globals.contact.phone`.

The footer of a new site, from Starter, shows the tagline, address, opening hours, email and phone of its **Studio** global this way, so you change them once for every page.

## In other languages

On a site with several [languages](/content/languages), you translate a global as you translate a page: open its values and press the language button in the toolbar. The translation has a value for every field, and is published on its own. A language without a published translation shows the values of the original.

This is also how the words in your templates and components get translated: put them in a global, and bind the blocks to it.

## For developers

### The global file

A global is a collection with `type: global`, defined in `content/collections/<handle>.yaml`. It is kept in files unless you choose the database, and its one entry holds the values:

```yaml
# content/collections/contact.yaml
type: global
title: Contact
icon: phone
driver: files
fields:
  - handle: email
    type: email
  - handle: phone
    type: text
```

```markdown
---
# content/collections/contact/contact.md
id: 01m7k5x02czhj1w8sj5t5vmfby
title: Contact
status: published
email: hello@acme.com
phone: '+31 20 123 4567'
---
```

A translation is an entry in the folder of its language, like `content/collections/contact/de/contact.md`. A global has no URL, template or other type: `collections/save` refuses them. Agents change its values with `entries/update` and `entries/publish`, and translate them with `entries/create` and the original's `originId`.

Add `api: true` to make a global's values public at `GET /api/v1/content/<handle>`, as its one entry. See [REST API](/agents/rest-api#the-content-api).

### Bindings

Connect any block to a global value with the path `globals.<global>.<field>`. Inside a longer text, wrap it in braces:

```json
{ "type": "link", "props": { "label": "Email us" }, "bind": { "url": "mailto:{globals.contact.email}" } }
{ "type": "paragraph", "bind": { "text": "globals.contact.phone", "visible": "globals.contact.phone" } }
```

Only published values reach the site, in the page's language where that translation is published. In PHP, read one with `cms_global('contact.phone')`.

### Rebuilds

A page that reads a global is rebuilt when the global's values change, a new translation included, as long as **Rebuild Automatically on Publish** is on under **Settings → General** (it is by default).
