---
id: 01m645d476k2kt5a124vaqka71
title: Using accounts
position: 10
group: 'Build'
description: Current user, roles, access and gating from any plugin, with no dependency on another plugin.
---
[Public accounts](/operations/public-accounts) are built in, so a plugin needs nothing in `requires` to use them. `cms()->accounts()` answers sensibly with public accounts off: nobody signs up, and access you grant waits until someone can sign in.

```php
$accounts = cms()->accounts();

$accounts->enabled();                 // the site has public accounts
$user = $accounts->current();         // ?Cms\Users\User: this request's person. A suspended or stale session gets null
$accounts->isVisitor($user);          // no admin access
$accounts->signInUrl('/next', 'de');  // where to send someone; null with accounts off
$accounts->pathOf('account', 'de');   // the address of an account page

// What they hold. A role counts, and so does a grant.
$accounts->holds($user, 'course-php');
$accounts->holdsAny($user, ['gold', 'silver']);
$accounts->grant($user, 'course-php', source: 'my-shop', until: now()->addYear());
$accounts->revoke($user, 'course-php', source: 'my-shop');

// A buyer who has no account yet: made with no password, nothing sent. They claim it by
// signing up or resetting their password, which proves the mailbox.
$user = $accounts->ensure('buyer@example.com', 'Bea', 'de');
```

An access name means whatever you decide. The source says who gave it: granting from two sources keeps both, and each source revokes only its own. Grants with a date stop counting when it passes, with no task to run. Nothing here knows about shops, courses or subscriptions.

## Gating

Editors set the rule on entries; see [Gated content](/content/gated-content). In code:

```php
$gate = cms()->entries()->gate();

$gate->decide($entry);  // full, teaser, sign-in, denied or missing, for this request
$gate->view($entry);    // the entry as this request may read it
$gate->isGated($entry); // has a rule at all
```

`->live()` queries already leave out what this request may not read, and return teasers instead of full entries, so a plugin that lists entries is safe by default. Admin code that has checked its own permission reads past that with `->ungated()`. If you load an entry by id or address, pass it through `view()` before showing it. A reader's copy cannot be saved: `save()` throws.

To decide access yourself, for example from an external system:

```php
cms()->hooks()->addFilter('gate.allows', function (bool $allowed, User $user, Entry $entry, array $rule) {
    return $allowed || MyMemberships::has($user, $rule['access']);
});
```

## Your own account pages

A screen is a block document that wears the site's design. Your plugin ships no template:

```php
$hooks->addFilter('account.screens', fn (array $screens) => [...$screens, 'orders' => [
    'label' => 'Orders',
    'path' => '/account/orders',
    'auth' => 'user',        // user, guest, token or any
    'nav' => true,           // in the Account Navigation block
    'order' => 30,           // its place there. Overview is 0, Profile 60, Email and password 70, Your data 80
    'seed' => fn () => [['id' => 'orders', 'type' => 'my-shop/orders', 'props' => []]],
]]);
```

The page gets the sign-in redirect, every language prefix and a line in **Design → Account Pages**, and a designer can customise it. Register your block as usual, and post forms to a route of your own in the `web` middleware group, which gives you the session and CSRF protection.

## Hooks

| Hook | Kind | Arguments | When |
|---|---|---|---|
| `account.created` | action | `$user` | An account exists: signed up, or made with `ensure()`. |
| `account.verified` | action | `$user` | The mailbox is proven. Link what you hold for this address here. |
| `account.signed-in`, `account.signed-out` | action | `$user` | |
| `account.updated`, `account.password-changed` | action | `$user` | |
| `account.email-changed` | action | `$user, $old` | |
| `account.granted`, `account.revoked` | action | `$user, $access, $source` | |
| `account.deleting` | action | `$user` | Inside the deletion's transaction. Delete or anonymise your data; throwing keeps the account. |
| `account.deleted` | action | `$id` | Afterwards. |
| `account.delete.blockers` | filter | `$reasons, $user` | Reasons the account can't be deleted now, shown to the person. |
| `account.export` | filter | `$sections, $user` | Add your section to their data download. |
| `account.screens` | filter | `$screens` | Add or change account pages. |
| `account.overview` | filter | `$html, $user` | What the account's first page shows under who is signed in. |
| `account.gate-notice` | filter | `$html, $user, $path` | What a teaser or a denied page says, for example a link to buy access. |
| `gate.allows` | filter | `$allowed, $user, $entry, $rule` | Whether someone may read a gated entry. |

Bind to `account.*` in blocks on pages rendered per person; see [Public accounts](/operations/public-accounts#how-they-look).
