---
id: 01m5wnc9y2yajdbdkwgmtxz24s
title: Email
position: 3
description: Send invitations, password resets and form notifications through SMTP or an email API.
---
Choose how Lettern sends email under **Settings → Email**:

| Transport | For |
|---|---|
| Log | Development: messages are written to the log instead of sent. The default. |
| SMTP | Any mail server or provider with SMTP credentials. |
| Brevo | Brevo's transactional API, with an API key. Install the free Brevo plugin first, from **Modules → Store**. |

Set the sender address and name, and an optional footer for every message. Use **Send a test email to me** in the command palette to check the setup, and **Email log** to see what was sent and what failed.

Mail wears your site's colours: the background, text and button come from the design system, through the `mail.colors` filter.

Passwords and API keys are stored encrypted; on servers you can set them as environment variables instead (`CMS_MAIL_SMTP_PASSWORD`, `CMS_MAIL_BREVO_API_KEY`).

## Other providers

Sending is a plugin contract. A provider plugin registers a transport with its settings fields — the Brevo plugin is twenty lines and a good template:

```php
$this->cms()->whenAvailable(\Cms\Mail\Transports::class, function ($transports) {
    $transports->register('postmark', 'Postmark', [
        ['handle' => 'postmark_token', 'type' => 'text', 'label' => 'Server token', 'secret' => true],
    ], fn (array $settings) => new PostmarkTransport($settings['postmark_token'] ?? ''));
});
```
