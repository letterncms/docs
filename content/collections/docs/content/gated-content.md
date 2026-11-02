---
id: 01m63dd9jm68j7r665q34ym6sq
title: Members-only content
position: 7
description: Keep pages for people with an account, a role or a purchase, and show everyone else a teaser.
---
Some pages are for members only: a magazine's articles, the lessons of a course, a client area. Lettern can keep them for the people who have access, and show everyone else the start of the page with a way to read on.

This needs [public accounts](/operations/public-accounts), so visitors can sign up and sign in. Once they're on, every page, and every other entry with its own address, has a **Who Can Read This** setting.

## Choose who can read a page

Open the page's details on the right, find **Who Can Read This**, and pick an **Access**:

| Access | A visitor who isn't signed in | Signed in, without access | With access |
|---|---|---|---|
| **Everyone** | Reads it | Reads it | Reads it |
| **Everyone Reads the Start** | Reads the start, then how to read on | Reads the start, and a note | Reads it |
| **Only People with Access** | Is sent to sign in, and back | Is told they have no access | Reads it |
| **Same as Above** | Follows the page above it | | |

Your team can always read every entry in a collection they're allowed to see.

## Lock a whole collection

Open the collection's **Settings** tab under **Settings → Collections** and set **Who Can Read This** there. It applies to every entry that doesn't say otherwise.

That's what **Same as Above** means: an entry follows the version it was translated from, then its parent page, then its collection. So a course locks all its lessons in one place, and one free lesson simply says **Everyone**.

## Choose who has access

Under **Who Has Access**, list the words that open the page: role names, or access names you make up, like `magazine` or `course-php`. Leave it empty to let in anyone with an account.

To give someone an access name, open them under **Settings → Users** and add it under **Access**. Plugins can give them too, for example after a purchase, and optionally until a date. See [Using accounts](/plugins/accounts).

## Show a teaser

With **Everyone Reads the Start**, visitors see the page up to a **Teaser Ends Here** block, or up to the number of **Words in the Teaser** (120 unless you set it), whichever comes first. Blocks are kept whole: one that doesn't fit is left out.

The entry's other fields stay hidden, unless you name them under **Fields in the Teaser**, like `excerpt`. SEO fields always stay public, because they're written to be seen.

## What stays hidden

The rule holds everywhere Lettern shows content, not just on the page itself:

- **Locked pages** are left out of lists, related entries, feeds, the sitemap and site search for anyone who can't read them. A link or menu item someone added by hand stays visible: it's a page you're meant to find, and sign in for.
- **Teasers** appear in lists and the sitemap with only their public part.
- **Members-only pages are never saved as plain files.** They're made for each visitor, and never cached.

## For developers

### In the collection file

```yaml
gate:
  mode: teaser          # public, teaser or locked
  access: [magazine]
  teaser_words: 120
  teaser_fields: [excerpt]
```

An entry stores the same object in its `gate` field; `mode: inherit` (or no rule) is **Same as Above**. The setting is added to every collection with its own URLs while public accounts are on.

### Where it's enforced

The rule is enforced where entries are read, so it holds for every way in:

- Locked entries are left out of lists, relations, feeds, the sitemap, the search index and the [Delivery API](/agents/rest-api) for anyone who may not read them.
- The API marks teasers `"gated": true`. Searching, filtering or sorting by withheld text skips them.
- A gated page is never a static file: it renders per person, no cache may keep it, and gating a published page removes its file at the next build. Markdown versions are not published for gated pages.
- With accounts off, or the Users module off, the rule still holds: a locked page answers 404, and a teaser stays a teaser.
