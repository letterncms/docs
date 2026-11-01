---
id: 01m63dd9jm68j7r665q34ym6sq
title: Gated content
position: 8
description: Limit a page to people with an account, a role or a purchase, with a teaser for everyone else.
---
With [public accounts](/operations/public-accounts) on, every entry has **Who Can Read This** in its sidebar, and every collection has it in its settings:

| Access | A stranger | Signed in, without access | With access |
|---|---|---|---|
| **Everyone** | Reads it | Reads it | Reads it |
| **Everyone Reads the Start** | The start, then how to read on | The start, and a note | Reads it |
| **Only People with Access** | Sent to sign in, and back | Told they have no access | Reads it |
| **Same as Above** | Follows the entry above it | | |

**Same as Above** looks at the language version it was translated from, then the parent, then the collection. So a course locks its lessons in one place, and one free lesson says **Everyone**.

**Who Has Access** is a list of words: role names, or access names you choose, like `magazine` or `course-php`. Leave it empty for anyone with an account. People get an access name from **Users** or from a [plugin](/plugins/accounts), for example after a purchase, optionally until a date. Your team can read everything in a collection they may view.

## Teasers

A teaser shows the entry's body up to a **Teaser Ends Here** block, or up to the number of words you set (120 by default), whichever comes first. Blocks are kept whole: one that doesn't fit is left out. Other fields are held back unless you name them under **Fields in the Teaser**, such as `excerpt`; SEO fields stay public, because they are written to be.

In a collection's YAML:

```yaml
gate:
  mode: teaser          # public, teaser or locked
  access: [magazine]
  teaser_words: 120
  teaser_fields: [excerpt]
```

## Where it holds

The rule is enforced where entries are read, so it holds everywhere:

- **Locked** entries are left out of lists, relations, feeds, the sitemap, the search index and the [Delivery API](/agents/rest-api), for anyone who may not read them. A menu item or link an editor added stays visible, because it's a page you are meant to find.
- **Teasers** appear in lists and the sitemap with only their public part. The API marks them `"gated": true`, and searching, filtering or sorting by withheld text skips them.
- **A gated page is never a static file.** It renders per person and no cache may keep it, and gating a published page removes its file at the next build. Markdown versions are not published for gated pages.
- **With accounts off**, or the Users module off, the rule still holds: a locked page answers 404, and a teaser stays a teaser.
