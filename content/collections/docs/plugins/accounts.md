---
id: 01m645d476k2kt5a124vaqka71
title: Using accounts
position: 8
description: Know who's visiting, give people access to things, gate content and add pages to their account, from any plugin.
---
[Visitor accounts](/operations/public-accounts) let visitors sign up and sign in to your site. Your plugin can use them to find out who's there, give someone access to a course or a download, and add pages to their account.

Accounts are built in, so your plugin needs nothing extra in `require`. `cms()->accounts()` also answers sensibly when a site has visitor accounts off: nobody signs up, and access you grant waits until someone can sign in.

## Give someone access

A typical case: someone bought a course, so they may read its lessons.

```php
$accounts = cms()->accounts();

// A buyer who may not have an account yet: made with no password, and nothing is sent.
$user = $accounts->ensure('buyer@example.com', 'Bea', 'de');

$accounts->grant($user, 'course-php', source: 'my-shop', until: now()->addYear());
```

Later, anywhere on the site:

```php
$accounts->holds($user, 'course-php'); // true, until the date passes
```

The buyer claims the account by signing up or resetting their password, which proves the mailbox.

### What access means

An access name means whatever you decide. Nothing here knows about shops, courses or subscriptions.

- A role counts as access, and so does a grant.
- The source says who gave it. Granting from two sources keeps both, and each source revokes only its own. Without a source, `revoke()` takes away every grant of that name.
- Grants with a date stop counting when it passes, with no task to run.

## The API

```php
$accounts = cms()->accounts();

$accounts->enabled();                 // the site has visitor accounts
$accounts->signUpOpen();              // a stranger can sign up right now (it needs working email)
$user = $accounts->current();         // ?Cms\Users\User: this request's person. A suspended or stale session gets null
$accounts->find('bea@example.com');   // ?User, by email
$accounts->isVisitor($user);          // no admin access
$accounts->signInUrl('/next', 'de');  // where to send someone; null with accounts off
$accounts->pathOf('account', 'de');   // the address of an account page

// What they hold. A role counts, and so does a grant.
$accounts->holds($user, 'course-php');
$accounts->holdsAny($user, ['gold', 'silver']);
$accounts->grants($user);             // every grant, with its source and end date
$accounts->grant($user, 'course-php', source: 'my-shop', until: now()->addYear());
$accounts->revoke($user, 'course-php', source: 'my-shop');

// A buyer who has no account yet: made with no password, nothing sent. They claim it by
// signing up or resetting their password, which proves the mailbox.
$user = $accounts->ensure('buyer@example.com', 'Bea', 'de');
```

## Gate content

Editors set who may read an entry; see [Members-only content](/content/gated-content). In code:

```php
$gate = cms()->entries()->gate();

$gate->decide($entry);  // full, teaser, sign-in, denied or missing, for this request
$gate->view($entry);    // the entry as this request may read it
$gate->isGated($entry); // has a rule at all
```

Your plugin is safe by default:

- `->live()` queries already leave out what this request may not read, and return teasers instead of full entries.
- Admin code that has checked its own permission reads past that with `->ungated()`.
- If you load an entry by id or address, pass it through `view()` before showing it.
- A reader's copy can't be saved: `save()` throws.

To decide access yourself, for example from an external system:

```php
cms()->hooks()->addFilter('gate.allows', function (bool $allowed, User $user, Entry $entry, array $rule) {
    return $allowed || MyMemberships::has($user, $rule['access']);
});
```

## Add a page to the account

An account page is a block document that wears the site's design, so your plugin ships no template:

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

The page gets the sign-in redirect, every language prefix and a row in **Pages** › **Account**, where a designer opens it to make it the site's own. `seed` is its starting content: register your block as usual, and post its forms to a route of your own in the `web` middleware group, which gives you the session and CSRF protection.

To show something per person in a block, bind to `account.*` on pages rendered per person; see [Visitor accounts](/operations/public-accounts#show-blocks-to-signed-in-visitors).

## Hooks

| Hook | Kind | Arguments | When |
|---|---|---|---|
| `account.created` | action | `$user` | An account exists: signed up, or made with `ensure()`. |
| `account.verified` | action | `$user` | The mailbox is proven. Link what you hold for this address here. |
| `account.signed-in`, `account.signed-out` | action | `$user` | |
| `account.updated`, `account.password-changed` | action | `$user` | |
| `account.email-changed` | action | `$user, $old` | |
| `account.granted`, `account.revoked` | action | `$user, $access, $source` | |
| `account.deleting` | action | `$user` | Inside the deletion's transaction. Delete or anonymize your data; throwing keeps the account. |
| `account.deleted` | action | `$id` | Afterward. |
| `account.delete.blockers` | filter | `$reasons, $user` | Reasons the account can't be deleted now, shown to the person. |
| `account.export` | filter | `$sections, $user` | Add your section to their data download. |
| `account.screens` | filter | `$screens` | Add or change account pages. |
| `account.overview` | filter | `$html, $user` | What the account's first page shows under who is signed in. |
| `account.gate-notice` | filter | `$html, $user, $path` | What a teaser or a denied page says, for example a link to buy access. |
| `gate.allows` | filter | `$allowed, $user, $entry, $rule` | Whether someone may read a gated entry. |
