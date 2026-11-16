---
id: 01m75fqzny67cckatwdnt2hgm8
title: Taxonomies
position: 8
description: 'Categories and tags: vocabularies of terms that entries are filed under, each term with a page of its own.'
---
A taxonomy is a set of terms you file entries under: the topics of a blog, the cuisines of a recipe site, the departments of a job board. There are two kinds:

- **Categories** are a vocabulary you curate. They can nest, like *Design → Typography*, and editors pick from them.
- **Tags** are flat, and editors make them as they write: a word typed into an entry that no tag has yet becomes a new tag when the entry is saved.

Terms are entries of their own. So each has a name you change in one place, a translation in every language, fields of its own (a description, a colour, a picture) and a page that lists what is filed under it.

## Make a taxonomy

1. Open **Structure** in the sidebar, then **Taxonomies**, and press **New Taxonomy**.
2. Name it, like *Topics*, and choose **Categories** or **Tags**.
3. Press **Create Taxonomy**. Under **Advanced** before that, its **URL Pattern** gives every term a page: `/topics/{slug}` for tags, and `/topics/{parent_uri}/{slug}` for categories, so a nested one is under its parent, `/topics/design/typography`.

![Making a taxonomy: a name, and categories or tags.](/media/screens/content-new-taxonomy.webp)

It appears under **Taxonomies** in the **Content** sidebar, below your collections of entries. Add categories there as you add entries; tags you can also add right from an entry.

A taxonomy is a collection with a type, so its **Fields** and **Settings** are those of any [collection](/content/collections). Its **Type** is in its settings and can change: a collection of entries can become tags, and tags categories. A taxonomy that a field still picks from stays one until that field is gone, and categories that nest can't become tags.

## File entries under terms

In the collection whose entries you want to file, such as *Posts*:

1. Open its **Fields** tab, press **Add Field** and pick **Terms**.
2. Choose the **Taxonomy** it picks from. **Maximum** limits how many terms an entry may have: `1` for one topic.

In every entry, a terms field of categories lists them to pick from. A terms field of tags is a box to type in: matching tags are offered as you type, **Enter** or a comma adds one, and a word no tag has yet becomes a tag when the entry is saved. Who may add entries to the taxonomy may add tags this way, and a tag someone adds who may not publish there waits as a draft until someone who may publishes it. Anyone else is told the tag isn't there.

## Show a term's page

A term's page is its entry's page, at the taxonomy's route: `/topics/news`. Give the taxonomy a [template](/design/templates) that lists what is filed under it with a **Repeat** block whose source is **Entries of This Term**. Turn on **Split into Pages** for long lists.

On an entry's page, a terms field gives you its terms with their own fields and pages: bind a link's text to `entry.topic.title` and its address to `entry.topic.url`, a colour to `entry.topic.colour`, or repeat over `entry.tags` and link each `item.url`. A page that shows a term is rebuilt when the term changes.

To list the terms themselves, with how many published entries each has, use the Repeat source **Taxonomy Terms**. Its **Of** is **All Terms**, for a topic index, or **This Page**, for the topics of the post on view.

The *Starter* site does all of this: its stories have a topic, one of four categories whose colour their tiles and title bands take, and tags, and every topic and tag has a page with its stories.

## Give a collection a page per term

A term's own page lists everything filed under it. A collection can have a page per term of its own too: the posts about *News* at `/blog/topics/news`, beside the jobs about it at `/jobs/topics/news`. That page is the term's archive in the collection.

1. Open the collection whose entries are filed, such as *Posts*, and its **Settings** tab.
2. Under **Term Archives**, press **Add Archive**, choose the **Taxonomy** and write the **URL Pattern**, such as `/blog/topics/{slug}`. `{slug}` is the term's.

Every published term now has that page. It shows the term's title and the collection's published entries filed under it, ten to a page, with **Previous** and **Next**. Entries behind a [gate](/content/gated-content) are left out for those who may not read them.

To design it, make a [template](/design/templates) with the handle `posts_archive`, the collection's handle and `_archive`, or `archive` for every collection without one of its own. In it:

- The page is the term: bind text to **Title** and to the term's fields, and place its body with **Page Content**.
- A **Repeat** with the source **Entries of This Term** lists the entries. Turn on **Split into Pages** for pages.
- `archive.title` is the collection's name, `archive.url` the archive's address and `archive.term_url` the term's own page.

Archives are built with the site and kept in step: publishing, unpublishing or re-filing an entry, an entry whose time is over, and renaming or deleting a term all rebuild or remove the pages they touch. They are in the site's search and, with the SEO plugin, in the sitemap of their language, each with a Markdown version. In a second language an archive has that language's prefix and names its other versions (`hreflang`).

An archive and a page cannot have the same address: saving a page where an archive is, or a term whose archive would be where a page is, is refused with the address.

## For developers

### How it is stored

The collection's `type` is `categories` or `tags`, and the field names it. A taxonomy's structure is its type's: categories are a tree, tags a list.

```yaml
# content/collections/topics.yaml
type: categories
title: Topics
singular: Topic
route: '/topics/{slug}'
```

```yaml
# in content/collections/posts.yaml
- handle: topic
  type: terms
  label: Topic
  taxonomy: topics
  max: 1
- handle: tags
  type: terms
  label: Tags
  taxonomy: tags
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

The pattern starts with `/` and has `{slug}` or `{id}` in it. `collections/save` refuses a taxonomy that is none, a pattern without the term, and an address an entry or another archive already has. It also refuses to turn a taxonomy that a terms field or an archive uses into entries, and nested entries into tags; `collections/delete` refuses to delete a taxonomy in use, naming where.

A terms field stores term ids. It also takes a term's slug or title, looked up in the entry's language: `"topic": ["news"]` is stored as its id. A name that no category has is refused (`There is no term “nope” in this language.`), and one that several nested categories share is refused with the id asked for. A name that no tag has becomes a tag of the entry's language, once however often it is named, when whoever writes the entry may create entries of that taxonomy: published, or a draft when they may not publish there. It is made as the entry is saved, so a save that is refused makes none, and a dry run makes it only as it makes the entry.

### Abilities

| Ability | Does |
|---|---|
| `terms/list` | The terms of a taxonomy, each with `count`: the entries of any collection that name it in a relation field, drafts included, and `archives`: its archive pages, as `{collection, uri}`. Takes `taxonomy`, `locale`, `search`, `page`, `perPage` |

Terms are created, renamed, translated, nested and deleted with the `entries/*` abilities, in the taxonomy's collection. `collections/list` says each collection's `type`.

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
curl "https://your-site.com/api/v1/content/posts?filter[topic]=news&expand=topic"
```

That is what the archive of *News* in *Posts* lists. `references=<term id>` gives what a term's own page lists when asked of each collection.
