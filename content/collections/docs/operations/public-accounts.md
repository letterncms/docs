---
id: 01m6rrkkgj90wstepzbeam9h70
title: Public accounts
position: 5
description: Let visitors sign up, sign in and manage their own account on your site, in your design. Off until you turn it on.
---
A site visitor is a user with no access to the admin. Under **Settings → Public Accounts**, turn on **Let Visitors Have Accounts** and your site gets these pages:

| Address | What it does |
|---|---|
| `/sign-in` | Sign in with email and password |
| `/sign-up` | Ask for a link by email |
| `/sign-up/complete` | Choose a name and a password, after the link |
| `/reset`, `/reset/new` | Reset a forgotten password by email |
| `/confirm-email` | Confirm a new email address, after the link |
| `/account` | Overview and sign-out |
| `/account/profile` | Name and the profile fields you mark public |
| `/account/security` | Change email address or password |
| `/account/privacy` | Download everything held about the account; delete it |
| `/account/deleted` | What someone sees after deleting their account |

On a site with more languages, each page is also at its language's prefix (`/de/sign-in`). An existing page at one of these addresses wins, and **Design → Account Pages** tells you so.

Sign-up and password reset need [working email](/operations/email). Without it, sign-in still works and those two pages say they are not available.

To let visitors edit a profile field, add `public: true` to it in `content/users.yaml`. Text, long text, select, toggle, date, URL, email and number fields can be public.

## Settings

- **Sign-Up:** anyone, or only people who already have an account. Someone a plugin made an account for can still claim it through a password reset.
- **Role for New Accounts:** `member` by default. Roles that open the admin are not offered, and are ignored if set by hand.
- **Terms to Agree To:** a page people must tick to sign up.
- **Page After Sign-In** and **Keep Me Signed In**.

## How they look

The pages are block documents: they use your `default` template and design system, and a plugin's pages join the same navigation. **Account Navigation** puts its links in a row, or in a column for a sidebar, and a template can hold it beside the page. To change one, open **Design → Account Pages**, choose **Customise**, and edit it on the canvas like a template. The forms are blocks in the **Account** category. Move them, restyle them through the design system's input, label and button styles, or put your own text around them. Your version takes over when you publish it; delete it to go back. Standard pages come in every language the plugins are translated into, and your version is translated like any entry.

Account pages are never static files, never cached and never indexed. The binding `account.name` (also `email`, `roles`, `fields`) is available on pages rendered per person; a static page has no visitor to show.

## Sign in and My account in your header

Any block can be shown only to people signed in, by binding `visible` to `account`, or only to people signed out, by binding `hidden` to `account`. That works on every page, built in advance or not: on a page everyone gets the same copy of, both are in the page, and the browser shows the right one before it's painted. It knows from a cookie that says only that someone is signed in, and comes and goes with the session.

The data `accounts` has the addresses and words to link to, in the page's language: `accounts.sign_in`, `accounts.sign_up` and `accounts.account`, each with a `url` and a `label` ("Sign in", "Create an account", "My account"). It's only there while public accounts are on, so a block with `visible` bound to `accounts` disappears when you turn them off. The starter header already has **Sign in** and **My account** this way.

## Who is who

**Users** lists your **Team** (who can open the admin) and your **Visitors** apart, so authors, pickers and the home screen only ever show the team. In someone's dialog you see and change their [access](/content/gated-content), and in the menu you can suspend them: they cannot sign in, and are signed out at their next request.

The admin's sign-in stays the admin's. A visitor's password does not open it, and answers exactly like a wrong one. The team signs in at `/admin`, with two-factor sign-in if they set it up, and the public sign-in and reset forms refuse their accounts rather than offering a second door. Once signed in at `/admin` they are recognised on the site too, and have its account pages, with what they bought there like anyone. Their profile, password and data stay in the admin: those pages send them to **Account** there.

## Security and privacy

- **No account until the mailbox answers.** Typing an address at sign-up creates nothing.
- **The same answer for every address**, in words and in time: anything that looks an address up happens after the response. Someone already registered gets an email saying so.
- **Links** work once, for 24 hours (30 minutes for a reset), are stored hashed, and leave the address bar when opened. A mail scanner opening a link uses nothing.
- **Forms** say what's wrong at the field it's about, and the focus goes to the first thing that needs attention. After a link is sent, the form makes way for the message.
- **Sign-in** is limited to 5 tries a minute per address and browser, and 20 per browser. Behind a proxy, set `TRUSTED_PROXIES` so Lettern sees real addresses.
- **Changing a password** ends every other session and every "keep me signed in".
- **Data export** is JSON with the profile, access and whatever plugins add. No password hash, no tokens.
- **Deletion** asks for the password and a tick, and is immediate: account, access and open links are gone, and plugins remove their data in the same transaction. A plugin can hold it back with a reason ("Cancel your subscription first"). Copies in your backups leave as your backups rotate.
- Text a visitor types has its tags removed, so it stays plain wherever a design shows it.
