---
id: 01m6rrkkgj90wstepzbeam9h70
title: Visitor accounts
position: 7
description: Let visitors sign up, sign in and manage their own account on your site, in your own design.
---
Visitor accounts let visitors have an account on your site, separate from the admin. They sign up, sign in and look after their own details, on pages that use your design. You need them for members-only pages. They're off until you turn them on.

## Turn them on

1. Open **Settings → Visitor Accounts**, the **Settings** tab of **Users**.
2. Turn on **Allow Visitor Accounts**. The settings below show once it's on.
3. Press **Save** in the bar at the bottom, or `⌘S`. Your site now has sign-up, sign-in and account pages.

Sign-up and password resets work by email, so [set up email](/operations/email) first. Without it, sign-in still works and those two pages say they aren't available.

## Choose who can sign up

| Setting | |
|---|---|
| **Who Can Sign Up** | **Anyone**, or **Only People You Add**: people who already have an account, for example because you or a plugin added them. |
| **Role for New Visitors** | **Visitor** by default. Roles that open the admin aren't offered. |
| **Terms to Agree To** | A page people must tick to agree to when they sign up. |
| **Page After Sign-In** | Where people land after signing in. `/account` by default. |
| **Offer “Keep Me Signed In”** | A tick box on the sign-in form. |

## The pages your site gets

| Address | What it does |
|---|---|
| `/sign-in` | Sign in with email and password |
| `/sign-up` | Ask for a link by email |
| `/sign-up/complete` | Choose a name and a password, after the link |
| `/reset`, `/reset/new` | Reset a forgotten password by email |
| `/confirm-email` | Confirm a new email address, after the link |
| `/account` | Overview and sign-out |
| `/account/profile` | Name, and the profile fields you make public |
| `/account/security` | Change email address or password |
| `/account/privacy` | Download everything held about the account, or delete it |
| `/account/deleted` | What someone sees after deleting their account |

On a site in several languages, each page is also at its language's prefix (`/de/sign-in`). If one of your own pages already has one of these addresses, yours wins, and **Pages** › **Account** marks that page *Address Taken*.

## Change how they look

The account pages use your default template and your design system, so they already look like the rest of the site. To change one:

1. Open **Pages**, then the **Accounts** tab. It lists the sign-in and account pages, each with the **Version** **Standard**.
2. Click the page. It opens in the editor as your own version, made from the standard one.
3. Edit it like any page: move the forms, restyle them, or add your own text around them. The forms are blocks in the **Account** category.
4. Publish. Your version takes over, and the page's **Version** says **Customized**. Until then the standard one stays live, and the page stays **Standard**. To go back, choose **Use Standard Version** in the page's ⋯ menu.

The **Account Navigation** block links to all account pages, in a row or in a column for a sidebar. The standard pages come in every language the plugins are translated into, and your versions are translated like any page.

## Sign in and My account in your header

The starter header already has **Sign in** and **My account** links. Each block shows only to the right people: **Sign in** to people who are signed out, **My account** to people who are signed in. When you turn visitor accounts off, both disappear. To build your own, see [For developers](#show-blocks-to-signed-in-visitors).

## Team and visitors

**Users** has your **Team**, who can open the admin, and your **Visitors** on tabs of their own. Click a visitor's row to open their dialog, where you see and change their [access](/content/gated-content) and can **Suspend** them: they can't sign in, and are signed out at their next visit.

The admin's sign-in stays separate. A visitor's password never opens the admin, and the team signs in at `/admin`, with two-factor sign-in if they set it up. Once signed in there, team members are recognized on the site too.

## Safe by design

- **No account until the mailbox answers.** Typing an address at sign-up creates nothing until the link in the email is opened.
- **No hints for attackers.** Sign-up and reset give the same answer for every address, so nobody can find out who has an account.
- **Links** in emails work once, and expire.
- **Changing a password** signs out every other device.
- **Visitors own their data.** They can download it, or delete their account themselves.

## For developers

### Public profile fields

To let visitors edit a profile field on `/account/profile`, add `public: true` to it in `content/users.yaml`. Text, long text, select, toggle, date, URL, email and number fields can be public.

### Show blocks to signed-in visitors

Bind a block's `visible` to `account` to show it only to people signed in, or its `hidden` to `account` to show it only to people signed out. That works on every page, built in advance or not: on a page everyone gets the same copy of, both are in the page, and the browser shows the right one before it's painted. It knows from a cookie that says only that someone is signed in, and comes and goes with the session.

The data `accounts` has the addresses and words to link to, in the page's language: `accounts.sign_in`, `accounts.sign_up` and `accounts.account`, each with a `url` and a `label` ("Sign in", "Create an account", "My account"). It's only there while visitor accounts are on, so a block with `visible` bound to `accounts` disappears when you turn them off.

On pages rendered per person, `account.name` (also `email`, `roles`, `fields`) is available. A static page has no visitor to show. Account pages themselves are never static files, never cached and never indexed. A plugin's account pages join the same navigation, and a template can hold it beside the page.

### Settings in detail

- **Who Can Sign Up:** with **Only People You Add**, someone a plugin made an account for can still claim it through a password reset.
- **Role for New Visitors:** roles that open the admin are ignored, even when set by hand.
- **Page After Sign-In** must be a path on this site.

### The team on the site

The public sign-in and reset forms refuse team accounts rather than offering a second door; a team password there answers exactly like a wrong one. Signed in at `/admin`, the team has the site's account pages too, with what they bought there like anyone. Their profile, password and data stay in the admin: those pages send them to **Account** there.

### Security and privacy in detail

- **The same answer for every address**, in words and in time: anything that looks an address up happens after the response. Someone already registered gets an email saying so.
- **Links** work once, for 24 hours (30 minutes for a reset), are stored hashed, and leave the address bar when opened. A mail scanner opening a link uses nothing.
- **Forms** say what's wrong at the field it's about, and the focus goes to the first thing that needs attention. After a link is sent, the form makes way for the message.
- **Sign-in** is limited to 5 tries a minute per address and browser, and 20 per browser. Behind a proxy, set `TRUSTED_PROXIES` so Lettern sees real addresses.
- **Changing a password** ends every other session and every "keep me signed in".
- **Data export** is JSON with the profile, access and whatever plugins add. No password hash, no tokens.
- **Deletion** asks for the password and a tick, and is immediate: account, access and open links are gone, and plugins remove their data in the same transaction. A plugin can hold it back with a reason ("Cancel your subscription first"). Copies in your backups leave as your backups rotate.
- Text a visitor types has its tags removed, so it stays plain wherever a design shows it.
