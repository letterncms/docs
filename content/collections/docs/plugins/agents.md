---
id: 01m6kqfpe0xhcnv56g02ynsc4d
title: Agents
position: 13
description: Answer plain language in the workspace. One contract, so the thread stays the same whichever model answers, or none.
---
The [workspace](/getting-started/workspace) answers commands and searches by itself. Plain language goes to an agent: a plugin that binds `Cms\Contracts\Agent`. The [assistant](/agents/assistant) is one, with Claude. Without one bound, the default `NoAgent` answers nobody, a message is a search, and nothing in the admin mentions AI.

Bind yours in your provider's `register()`, as Site binds `SiteBuilder`:

```php
$this->app->singleton(\Cms\Contracts\Agent::class, fn ($app) => $app->make(MyAgent::class));
```

## The contract

| Method | Does |
|---|---|
| `name()`, `label()` | A short, stable name stored with each answer (`assistant`), and what people call it (`Claude`). |
| `available(User $user)` | Whether it answers this person: set up, and theirs to use. The admin's manifest says so as `config.workspace.agent`. |
| `reply(Thread $thread, User $user, AgentMessage $message, Closure $emit, Closure $stopped)` | Answer a message. |
| `edit(...)` | The same, after the person changed an earlier message: forget your own history from `$message->replaces` on first. |
| `decide(Thread $thread, User $user, array $approved, Closure $emit, Closure $stopped)` | Go on after the person allowed some (or none) of the calls you asked about. |
| `interact(Thread $thread, User $user, array $action, Closure $emit, Closure $stopped)` | A click on an interface you answered with: identifiers only (`tool`, `node`, `name`), never what to run. |
| `state(Thread $thread, User $user)` | What the browser may see of your state, such as the model picked. |
| `title(Thread $thread, User $user)` | A short name for the thread from how it starts, or `null`. |

`AgentMessage` holds the `text`, the person's `turn` as stored, `context` (where they are and what the message carries, as the browser reports it), `options` (what your controls in the composer chose) and `earlier`: the thread's turns since you last answered, such as the commands the person ran. `Transcript::recap($message->earlier)` gives them as a short list to hand to a model, as data: their results are what the site holds.

## Streaming an answer

You never write the thread's turns. Call `$emit($event, $data)` as you work, and the workspace builds the answer from it, saves it, and streams it to the browser:

| Event | Data |
|---|---|
| `text`, `thinking` | `delta` |
| `tool` | `id`, `name`, `label`, and `ability` when the call runs one |
| `tool_result` | `id`, `input`, `ok`, `mutated`, `output`, `ability`, and `declined` or `surface` |
| `approval` | `calls`: each `id`, `name`, `label`, `input`, `destructive`, `untrusted` |
| `notice` | `tone`, `message` |
| `surface`, `surface_used` | An [interface](/plugins/generative-ui) you composed; one that was used (`id`) |

What you need to go on, such as your model's history and the calls waiting for approval, goes in `$thread->agent_state` (`$thread->state($key)`, `$thread->setState($key, $value)`), encrypted with the thread. Save it with `$thread->save()`. When `$stopped()` says the person left, finish the step you're on and return. Throw an `AbilityException` with words for the person when something fails: it's shown in the thread.

Run abilities through `cms()->abilities()->execute()` as the person, with the `assistant` transport, so permissions, validation and the audit log apply.

### Moving the admin

Offer `admin/open` as a tool, and your agent can take the person somewhere. Its input is `to`, a path of the admin (`/content/pages/<id>`, `/settings/site?field=name`, `/users?tab=visitors`, `?do=` for a named action), and an optional `label`. It refuses anything outside the admin and places the person may not see, and returns `{to, label}`. When a `tool_result` with `ability: "admin/open"` comes back `ok`, the screen goes there as you answer and the thread docks beside it; the row reads **Opened**, with a link. Reopening the thread later never moves the screen. `$message->context['path']` says where the person is now. Links in your Markdown to `/admin/…`, or to a path of the admin, open in the admin too.

The ability is offered to agents and the admin's own client only: not over MCP, REST or the CLI, and not in `/`. `$thread->untrusted` says the thread holds words others may have written: ask before anything that goes live.

## In the composer

Your controls go in the composer's footer through the `workspace.composer` slot. They get the `thread`, your `state`, the `options` chosen so far and `setOption(name, value)`; options go with the next message. Your `/` and `@` sources are [registered](/plugins/admin-extensions#in-the-workspace) like any other; offer them only when you're the one answering.
