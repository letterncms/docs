---
id: 01m5wn8r9nmvf5w42c41hf73y1
title: Forms
position: 3
group: 'In the editor'
description: Build forms with the block editor, embed them anywhere, and receive spam-filtered submissions — even on a static site.
---
## Building a form

Open **Forms** and create one. Fields are blocks: type `/` to add short and long text, email, phone, website, number, date, dropdown, choice, checkboxes, a single checkbox, consent, file upload or a hidden value, and put fields side by side with columns. Any field can be shown only when another field has (or lacks) a value.

**Settings** holds the submit button text, what happens after sending (a message or a redirect), who gets notified and with which subject, which field is the reply-to address, an optional confirmation email to the sender, a webhook, and whether to store submissions. How long submissions are kept is a site-wide setting under **Settings → Forms**.

Add it to any page with the **Form** block.

## Submissions

Forms submit to `/api/forms/<handle>`, so they work on static pages. Without JavaScript the browser posts normally and is redirected back; with it, the form shows errors inline and the confirmation without reloading.

Every submission is validated against the form's fields and checked for spam — a hidden honeypot field, a minimum time to fill in the form, rate limits and an origin check. Uploaded files are type-checked and stored in `storage/`, outside `public/`, downloadable only by signed-in users.

A submission keeps the page it came from, the browser's language and user agent, and a hash of the IP address. The hash uses a salt that is replaced and thrown away every day, so it can show a flood from one address within a day but can't link a person's submissions across days. The address itself isn't stored.

Find submissions in the form's **Submissions** tab: mark them read, spam or archived, or export them as CSV (with protection against spreadsheet formula injection).

## Integrations

- **Email** notifications use your [email settings](/operations/email).
- **Webhooks** receive each submission as JSON.
- The `form.submitted` hook lets a plugin forward submissions anywhere else.

## In other languages

On a multilingual site a form has a **Languages** tab, with the button, the success message, the confirmation email and each field's label, help text, placeholder and options per language. A page shows its form in the page's language, and error messages come back in it.

Only words change. Field names and rules stay those of the form, so submissions look the same in every language: write options as `value|Label` and keep the value. On disk they sit under `locales` in the form's JSON:

```json
"locales": {
  "de": {
    "settings": { "submit": "Senden", "success": "Danke. Wir melden uns per E-Mail." },
    "fields": { "name": { "label": "Name" }, "kind": { "options": "site|Website\napp|App" } }
  }
}
```
