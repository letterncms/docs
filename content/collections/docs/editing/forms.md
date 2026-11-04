---
id: 01m5wn8r9nmvf5w42c41hf73y1
title: Forms
position: 3
description: Build a contact or quote form like you build a page, add it anywhere, and read what people send.
---
Forms let visitors get in touch, ask for a quote or sign up. You build one the way you write a page, add it to any page with a block, and read what people send right in the admin. Spam is filtered out for you.

## Build a form

1. Open **Forms** in the sidebar and press **New Form**.
2. Give it a name, like *Quote Request*, and press **Create**. It starts with three fields: name, email and message.
3. In the **Fields** tab, change them, or type `/` to add more. Use a **Columns** block to put fields side by side.
4. Press **Save**.

Select a field to change its label, help text and whether it's required, just like any other block. **Rename** and **Delete** are in the form's top bar, on every tab. Deleting a form keeps its submissions.

| Field | For |
|---|---|
| **Short Text**, **Long Text** | Names, messages, anything typed |
| **Email**, **Phone**, **Website** | Contact details |
| **Number**, **Date** | Quantities, a day to book |
| **Dropdown**, **Choice**, **Checkboxes** | Picking from a list of options |
| **Checkbox** | A single yes or no |
| **Consent** | Agreeing to your privacy policy |
| **File Upload** | Documents or images, up to a size you choose |
| **Hidden Value** | Something sent along without being shown |

### Show a field only sometimes

Any field can appear only when another one has a certain answer. In the field's **Only Show When**, enter the other field's name and pick whether it's equal to a value, not equal to it, filled in or empty.

## Choose what happens when someone sends it

Open the **Settings** tab.

| Setting | What it does |
|---|---|
| **Button Label** | The text on the send button |
| **Accept Submissions** | Turn off to stop taking new ones |
| **Success Message** | What people see after sending |
| **Or Redirect To** | Send them to a thank-you page instead |
| **Email Submissions To** | Who gets an email for each submission |
| **Email Subject** | That email's subject. Use `{form}` or any `{field_name}` |
| **Reply-to Field** | The field with the sender's email, so you can just reply |
| **Send the Person a Confirmation Email** | A copy for the sender, with your own subject and message |
| **Keep Submissions in Lettern** | Store them in the admin, not only send them by email |
| **Hidden Spam Trap**, **Minimum Seconds to Fill In** | Spam protection, on by default |
| **Webhook** | Send each submission to another service, like Zapier, Make, n8n or your CRM |

Emails go out through your [email settings](/operations/email).

## Add it to a page

Open the page, add a **Form** block where you want it, and pick your form under **Choose a Form** in its settings. With no forms yet, the list offers **New Form**, which leads to **Forms** to make one.

## Read submissions

The **Forms** item in the sidebar shows how many submissions are unread. Open a form and its **Submissions** tab:

- Switch between **Inbox**, **Unread**, **Archived** and **Spam**, or search.
- Click one to read it, with the page it came from. **Reply** opens an email to the sender, when the form asks for one. **Spam** and **Archive** file it away.
- Select several to **Mark Read**, **Archive**, mark as **Spam** or **Delete** them at once.
- **Export CSV**, in the top bar, downloads them for a spreadsheet.

The **Form Submissions** widget puts new ones on your Dashboard too.

To delete old submissions automatically, open the **Settings** tab of **Forms** (also under **Settings → Forms**) and set **Keep Submissions For** to a number of days. `0`, the default, keeps them forever.

## Spam and privacy

Every form is protected without a captcha: a hidden field only bots fill in, a minimum time to fill the form in, a limit on how often one address can send, and a check that the submission came from your site. Every answer is checked against the form's fields too.

Lettern keeps only what you need to handle a submission: the answers, the page it came from, the browser's language and type. Visitors' IP addresses are never stored. Uploaded files are private, and only people allowed to see submissions can download them.

## In other languages

On a multilingual site, a form gets a **Languages** tab. Translate the button, the success message, the confirmation email, and each field's label, help text, placeholder and options. A page shows its form in the page's language, and error messages come back in it too.

Only the words change, so submissions look the same in every language. Options are written as `value|Label`: translate the label and keep the value.

## For developers

### Where forms live

Each form is a JSON file, `content/forms/<handle>.json`, so it can live in git. Its fields are blocks of the types `form/text`, `form/email`, `form/tel`, `form/url`, `form/number`, `form/date`, `form/textarea`, `form/select`, `form/radio`, `form/checkboxes`, `form/checkbox`, `form/consent`, `form/file` and `form/hidden`. A page embeds it with the `forms/form` block: `{"form": "<handle>"}`.

Translations sit under `locales`:

```json
"locales": {
  "de": {
    "settings": { "submit": "Senden", "success": "Danke. Wir melden uns per E-Mail." },
    "fields": { "name": { "label": "Name" }, "kind": { "options": "site|Website\napp|App" } }
  }
}
```

### How submissions arrive

Forms post to `/api/forms/<handle>`, so they work on static pages. Without JavaScript the browser posts normally and is redirected back. With it, the form shows errors inline and the confirmation without reloading.

If the published site is hosted somewhere other than the admin, set **Submission Address** on the **Settings** tab of **Forms** to the admin's URL, and add the site under **Other Allowed Websites**. Submissions sent from any other website are refused.

### Spam limits and stored data

One address can send 6 submissions a minute to a form, and 60 an hour in all. A submission keeps the page, the browser's preferred language, its user agent (up to 300 characters) and a hash of the IP address. The hash uses a salt that is replaced and thrown away every day: it can show a flood from one address within a day, but can't link a person's submissions across days.

Uploaded files are type-checked and stored under `storage/app/forms/`, outside `public/`. The CSV export guards against spreadsheet formula injection.

### Webhooks and hooks

A webhook receives each submission as JSON, at an `https://` URL. The `form.submitted` hook lets a plugin forward submissions anywhere else.

### Permissions and abilities

| Permission | Allows |
|---|---|
| `forms.view`, **View Form Submissions** | Reading submissions and downloading their files |
| `forms.manage`, **Manage Forms** | Building forms and changing their settings |

Forms are also abilities, for the assistant, MCP and the API: `forms/list`, `forms/get`, `forms/create`, `forms/save`, `forms/configure`, `forms/delete`, `forms/submissions`, `forms/submission`, `forms/submission-update`, `forms/submission-delete`, `forms/export` and `forms/activity`.
