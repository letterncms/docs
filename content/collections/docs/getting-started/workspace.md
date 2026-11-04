---
id: 01m6kqfpe0vt26spccrv6v5zqy
title: Workspace
position: 3
description: Run the whole site from one place beside the page. Commands, search and, if you want it, AI, each answered with something to act on.
---
The workspace sits at the right edge of every screen. Run a command, find anything, or with the [assistant](/agents/assistant) set up, ask in plain words. Each turn is answered with something you can act on, right there, while the page stays open and live beside it. All of it works without AI.

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"Type / for a command, give what it asks for, and act on the answer.\"><div class=\"docs-fig__flow\"><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>/ New Page</b><span class=\"docs-card__field\">Summer Menu</span></div><b>Run</b><small>A command, with what it needs</small></div><span class=\"docs-fig__op docs-fig__op--to\">→</span><div class=\"docs-fig__step\"><div class=\"docs-card\"><b>Created “Summer Menu”</b><span class=\"docs-card__field\">Open · Publish · Add to Menu</span></div><b>Act on it</b><small>The next step is one click</small></div></div></figure>"}}
:::

## Open it

| Press | To |
|---|---|
| `⌘J` | Open or close the workspace |
| **New Chat** | Start a fresh thread: at the top of the sidebar, or **+** at the top of the workspace |
| `/` at the start of a line | Pick a command |
| `Enter` | Search for what you typed, or with the assistant, ask it |
| `Esc` | Put the workspace away |

Each thread keeps what you did, in order, so you can come back to it. The history button at the top lists your threads by age, and **Full Size** gives a thread the whole window with the list beside it. **Rename Chat**, in the thread's `⋯` menu or on its row in the list, names it as you like. Threads are private: nobody else can open yours, and they're encrypted in the database.

## Commands

Type `/` and pick from what you may do here: make something (**New Page**, **New Post**, **Invite User**), go somewhere, or change a settings page. Keep typing to narrow it down, and every other action the site has appears too, grouped by what it belongs to.

A command that needs nothing more runs at once. One that does asks for it right in the composer: the fields it requires, marked, and **Run**. **New Page** asks for a title; **General Settings** shows that page's settings as they are now and saves what you change. A page or a person is picked by name. If something isn't right, it says so on the field, and nothing runs until it is.

Commands run as you, with your permissions, and go in the audit log like anything you do on a screen.

## Act on the answer

A command is answered with what it did, and the next steps:

- A new page: **Open**, **Publish**, **Add to Menu**, or **Delete** to take it back.
- A published page: **Open**, **View on Site**, **Unpublish**.
- An invitation: **Open**, **Resend Invitation**, **Delete**.
- A form, a menu, a global set, a settings page or a discount: where it is, and a way back where there is one.

Those buttons run as commands in the same thread, so it keeps a record of everything; one that asks first, like **Add to Menu**, asks in the composer. A button for something that's gone since says so. A list comes back as a table you can open rows from, and anything else as its values.

## Search

Type a few words and press `Enter`, or with the assistant set up, `/` and your words, then **Search for**. The answer lists what matches, line by line, grouped: places in the admin and settings pages, pages and posts, people, files, and what plugins add. Only what you may see is listed, and each line opens where it is. Search costs nothing and is instant.

## With the assistant

Set up the [assistant](/agents/assistant), and plain words go to it in the same thread. It sees the commands you ran and what you searched since it last answered, so *"publish it"* after **New Page** means that page. It asks before anything that goes live or is hard to undo. Without it, nothing in the workspace mentions AI.

Ask it to go somewhere, and it takes you there: *"go to the last edited page"*, *"open the General settings at the site name"* or *"show me the visitors"* opens that screen as it answers, with the thread beside it. Places it mentions are links that open in the admin.

## For developers

### Answers

Every ability can be a command. To answer it with more than its values, give it an `answer`: a [view](/plugins/views) tree, checked for the person like any view and kept with the thread. `Answers::done()` says what happened in a line, with the next actions:

```php
use Cms\Modules\Workspace\Answers;

$a->register('reviews/approve', [
    'label' => 'Approve Review',
    'permission' => 'reviews.manage',
    'input' => ['type' => 'object', 'properties' => ['id' => ['type' => 'string']], 'required' => ['id']],
    'answer' => static fn (array $review) => Answers::done(__('Approved “:title”', ['title' => $review['title']]), null, [
        ['label' => __('Open'), 'icon' => 'arrow-right', 'variant' => 'primary', 'to' => '/reviews/'.$review['id']],
        ['label' => __('Hide'), 'icon' => 'eye-off', 'ability' => 'reviews/hide', 'input' => ['id' => $review['id']]],
    ]),
    'handler' => fn (array $in) => $this->approve($in['id']),
]);
```

Its buttons leave out what the person may not run, as in any view. Without an `answer`, a list is drawn as records with its first useful values as columns, a record as its values, and a result that names a place (`to`, or an entry's `collection` and `id`) gets **Open**. The `workspace.answer` filter (`$view`, `$ability`, `$result`, `$input`, `$user`) adds to any answer: the navigation plugin adds **Add to Menu** to a new page's this way. Values written into an answer go through `Answers::literal()`, so a title with braces never reads as a template.

### Asking for input

A command's form comes from its input schema: a string is a text field, a choice (`enum`) a select, a boolean a switch, a number a number, a list of words tags, anything else JSON. A property's `title` is its label. A choice gets its words from `x-labels` (`{value: label}`) or from `oneOf` with `const` and `title`. An `id` (or `entryId`, `userId`) of an entry or a person is picked by name; an ability that requires any other raw id isn't offered under `/`, and stays a button in the views and answers that have the id.

```php
'input' => ['type' => 'object', 'properties' => [
    'tone' => ['type' => 'string', 'enum' => ['warm', 'plain'], 'x-labels' => ['warm' => __('Warm'), 'plain' => __('Plain')], 'title' => __('Tone')],
], 'required' => ['tone']],
```

### Search

Add a section with the `workspace.search` filter:

```php
$this->cms()->hooks()->addFilter('workspace.search', fn (array $sections, string $query, User $user) => [...$sections, [
    'id' => 'reviews', 'title' => __('Reviews'),
    'items' => Review::search($query)->limit(6)->get()->map(fn ($r) => ['label' => $r->title, 'detail' => $r->author, 'icon' => 'star', 'to' => '/reviews/'.$r->id])->all(),
]]);
```

Only lines that lead to a place of the admin are kept. The `workspace/search` ability returns the same sections.

### The thread

`POST /api/admin/workspace/turn` takes one of `command` (`{ability, input, label}`), `search`, `message`, `approve` or `action`, and answers with server-sent events: `thread`, a `turn` for each turn as it's stored, the answer's events, then `done` or `error`. A thread's turns are the same for every client: what the person said, ran or searched, and answers made of text, tool calls, views, interfaces, notices and approvals. `threads/list`, `threads/get`, `threads/rename` and `threads/delete` are the admin's own: no tokens, agents or CLI. To answer plain language, a plugin provides an [agent](/plugins/agents).
