---
id: 01m75g1yp95zzn6vrzk92pbfzf
title: Newsletter signups
position: 13
description: 'Let visitors join your Brevo newsletter lists from a signup block, with double opt-in.'
---
With the free Brevo plugin, visitors join your [Brevo](https://www.brevo.com) newsletter lists from a block on your site. The same plugin [sends the site's email](/operations/email) through Brevo.

Install it from **Plugins**, or with `composer require letterncms/brevo`.

## Set it up

1. Open **Settings → Brevo**. If you already entered a Brevo API key under **Settings → Email**, that one is used for lists too; otherwise enter the **Brevo API Key** here. Find it in Brevo under **SMTP & API → API keys**.
2. Choose the **Default List**: where signups go when a block doesn't name a list.

## Add the signup to a page

Insert the **Newsletter Signup** block. It is an email field and a button that look like every other form on the site, and it works without a script.

| Setting | Does |
|---|---|
| **List** | The Brevo list for this block. Empty: the default list |
| **Label**, **Button Label** | What the field and the button say: *Email* and *Subscribe* unless you set them |
| **Consent Sentence** | A line under the field, such as what you will send and how often |
| **Success Message** | What visitors read after signing up |

## Double opt-in

**Confirm Addresses by Email**, under **Confirmation** in **Settings → Brevo**, is on by default. A visitor who signs up gets an email with a link, good for two days. The link opens a page in your site's design whose button confirms, and only then does the address reach Brevo. So a mail scanner that follows links subscribes nobody, and nobody is subscribed by someone else typing their address.

| Setting | Does |
|---|---|
| **Confirmation Subject**, **Confirmation Message** | What that email says. Left empty, it is written in the language of the page the person signed up on |
| **After Confirming, Go To** | A page of the site to show instead of the plain confirmation, such as a thank-you page |

One address is mailed at most three times an hour.

## For developers

### A site hosted elsewhere

When the built site is hosted somewhere other than the admin, signups go to the **Submission Address** set under **Forms → Settings** (`endpoint` in `config/forms.yaml`): one place says where the CMS answers. See [Forms](/editing/forms).

### The block

The block's type is `brevo/signup`, with the props `list`, `label`, `button`, `consent` and `success`.

### Abilities and hooks

| Ability | Does |
|---|---|
| `brevo/lists` | The account's contact lists, with id, name and subscribers |
| `brevo/subscribe` | Adds an address to a list right away, without a confirmation email |
| `brevo/stats` | Transactional email totals for the last 7 days |

All three need `settings.manage`. Agents read `cms://brevo` for whether a key is set, the default list and whether addresses are confirmed.

- `brevo.subscribed` (action): `string $email, int $list`, after an address was added to a list.
- `fields.options.brevo-lists` (filter): the lists a select field with `dynamic: brevo-lists` offers.
