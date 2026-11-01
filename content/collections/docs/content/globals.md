---
id: 01m5wmrf5hn71fkqbrdzf3ah04
title: Global sets
position: 3
group: 'Model'
description: Values used all over the site — contact details, a footer note, social links — edited in one place.
---
A global set is a group of fields with one set of values. Create sets in **Globals**; each is stored as YAML in `content/globals/`:

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

## On the site

Connect any block to a global value with the path `globals.<set>.<field>` — in the block workspace, **Content → database icon → Globals**:

```json
{ "type": "link", "props": { "label": "Email us" }, "bind": { "url": "mailto:{globals.contact.email}" } }
{ "type": "paragraph", "bind": { "text": "globals.contact.phone", "visible": "globals.contact.phone" } }
```

PHP code reads one with `cms_global('contact.phone')`.

On a multilingual site, values follow the language of the page; anything not translated falls back to the default language. Pages that use globals are rebuilt when a set changes.
