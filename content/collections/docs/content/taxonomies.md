---
id: 01m75fqzny67cckatwdnt2hgm8
title: Taxonomies
position: 8
description: 'Topics, categories, authors: a vocabulary of terms that entries are filed under, each term with a page of its own.'
---
A taxonomy is a set of terms you file entries under: the topics of a blog, the cuisines of a recipe site, the departments of a job board. Unlike free tags, terms are entries of their own. So each has a name you can change in one place, a translation in every language, and a page that lists what is filed under it.

Use **Tags** for free words without pages. Use a taxonomy when the words matter: when visitors browse by them, or when a typo shouldn't make a second topic.

## Make a taxonomy

A taxonomy is a collection with one switch turned on.

1. Create a [collection](/content/collections), like *Topics*. Give it a **URL Pattern**, such as `/topics/{slug}`, so every term gets a page. Choose **Tree** as its structure if terms should nest, like *Design → Typography*.
2. Open its **Settings** tab and turn on **Taxonomy**.
3. Add its terms as entries: *News*, *Design*.

Because terms are entries, everything entries can do works for them: rename, translate, nest, reorder, give them a description or an image with [fields](/content/fields).

## File entries under terms

In the collection whose entries you want to file, such as *Posts*:

1. Open its **Fields** tab, press **Add Field** and pick **Terms**.
2. Choose the **Taxonomy** it picks from. **Maximum** limits how many terms an entry may have.

Editors then pick terms from the taxonomy in every entry.

## Show a term's page

A term's page is its entry's page, at the taxonomy's route: `/topics/news`. To list what is filed under it, give the taxonomy a [template](/design/templates) with a **Repeat** block:

- **Source**: **Collection Entries**, of the collection you filed, such as *Posts*.
- **Only Entries Linking To**: **This Page**.

Each term's page now lists its own posts.

## Give a collection a page per term

A term's own page lists everything filed under it. A collection can have a page per term of its own too: the posts about *News* at `/blog/topics/news`, beside the jobs about it at `/jobs/topics/news`. That page is the term's archive in the collection.

1. Open the collection whose entries are filed, such as *Posts*, and its **Settings** tab.
2. Under **Term Archives**, press **Add Archive**, choose the **Taxonomy** and write the **URL Pattern**, such as `/blog/topics/{slug}`. `{slug}` is the term's.

Every published term now has that page. It shows the term's title and the collection's published entries filed under it, ten to a page, with **Previous** and **Next**. Entries behind a [gate](/content/gated-content) are left out for those who may not read them.

To design it, make a [template](/design/templates) with the handle `posts_archive`, the collection's handle and `_archive`, or `archive` for every collection without one of its own. In it:

- The page is the term: bind text to **Title** and to the term's fields, and place its body with **Page Content**.
- A **Repeat** with the source **Entries of This Term** lists the entries. Turn on **Paginate** for pages.
- `archive.title` is the collection's name, `archive.url` the archive's address and `archive.term_url` the term's own page.

The same Repeat source on the term's own page lists the entries of every collection.

Archives are built with the site and kept in step: publishing, unpublishing or re-filing an entry, an entry whose time is over, and renaming or deleting a term all rebuild or remove the pages they touch. They are in the site's search and, with the SEO plugin, in the sitemap of their language, each with a Markdown version. In a second language an archive has that language's prefix and names its other versions (`hreflang`).

An archive and a page cannot have the same address: saving a page where an archive is, or a term whose archive would be where a page is, is refused with the address.

To list the terms themselves, with how many published entries each has, use the Repeat source **Taxonomy Terms**. Its **Of** is **All Terms**, for a topic index, or **This Page**, for the topics of the post on view.

## For developers

### How it is stored

The collection carries `taxonomy: true`, and the field names it:

```yaml
# content/collections/topics.yaml
title: Topics
singular: Topic
structure: tree
route: '/topics/{slug}'
taxonomy: true
```

```yaml
# in content/collections/posts.yaml
- handle: topics
  type: terms
  label: Topics
  taxonomy: topics
  max: 3
```

A collection's archives name the taxonomy and the address. A language can have its own:

```yaml
# in content/collections/posts.yaml
archives:
  topics: '/blog/topics/{slug}'
  authors:
    route: '/blog/by/{slug}'
    routes:
      de: '/blog/von/{slug}'
```

The pattern starts with `/` and has `{slug}` or `{id}` in it. `collections/save` refuses a taxonomy that is none, a pattern without the term, and an address an entry or another archive already has.

A terms field stores term ids. It also takes a term's slug or title, looked up in the entry's language: `"topics": ["news", "Design"]` is stored as the two ids. A name that no term has is refused (`There is no term “nope” in this language.`), and one that several nested terms share is refused with the id asked for.

### Abilities

| Ability | Does |
|---|---|
| `terms/list` | The terms of a taxonomy, each with `count`: the entries of any collection that name it in a relation field, drafts included, and `archives`: its archive pages, as `{collection, uri}`. Takes `taxonomy`, `locale`, `search`, `page`, `perPage` |
| `terms/import` | Turns a collection's free tags into terms: every tag of the tags field `from` becomes a published term of the taxonomy the terms field `into` picks from. Terms are found by title, so running it again changes nothing. A tag whose slug is taken gets one of its own and is reported under `collisions`. `clear: true` empties the tags afterwards |

Terms are created, renamed, translated, nested and deleted with the `entries/*` abilities, in the taxonomy's collection.

```bash
php cms run terms/list taxonomy=topics
```

```json
{
    "data": {
        "items": [
            { "id": "01m75fkz8xmta2n3djr5xn4fee", "collection": "topics", "title": "News", "slug": "news", "uri": "/topics/news", "status": "published", "count": 1, "…": "…" },
            { "id": "01m75fkzmtc82pz2cgqwx1pnp4", "collection": "topics", "title": "Design", "slug": "design", "uri": "/topics/design", "status": "published", "count": 1, "…": "…" }
        ]
    }
}
```

### In the content API

The [content API](/agents/rest-api#read-published-content) filters by term, by slug or by id, as it does for any relation field, and gives the terms as entries with `expand`:

```bash
curl "https://your-site.com/api/v1/content/posts?filter[topics]=news&expand=topics"
```

That is what the archive of *News* in *Posts* lists. `references=<term id>` gives what a term's own page lists when asked of each collection.
