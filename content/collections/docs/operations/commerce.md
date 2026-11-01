---
id: 01m6rrkkgj90wstepzbeam9h71
title: Selling with Commerce
position: 6
description: Sell downloads, courses, memberships or anything else from your site, with hosted checkout, proper invoices, EU VAT, refunds and Peppol.
---
Commerce is a paid plugin from the store. It sells whatever you add as a product. Your buyers pay on a page hosted by the payment provider, so card details never reach your site, and you get your own numbered invoices, whichever provider you use. Your buyers become [accounts](/operations/public-accounts) with no admin access.

It runs in test mode from the moment you turn it on, with no licence and no account anywhere. The built-in sandbox stands in for a payment provider, with **Pay** and **Decline** buttons, so you can try a whole sale first.

## Sell something

1. Under **Commerce → Products**, add a product: a name, an SKU and a price. Say whether the price is without VAT or is what everyone pays, and whether it's one-off or recurring.
2. Say what it delivers. Attach a **file** and buyers get a download link for as long as their purchase stands. Name an **access** like `magazine` and buyers can read [gated content](/content/gated-content) with that access. Both go away by themselves on a refund or a lost chargeback.
3. Put a **Products** or **Buy Button** block on any page. Both link to `/checkout?product=<sku>`.

The buyer fills in who they are, sees the exact total with VAT, and then goes to the payment page. Afterwards the order page at `/checkout/done` says how it went, shows the invoice and the downloads, and a link to it goes by email. If the payment fails it says nothing was charged, and offers another try.

Customers with an account also find everything at `/account/orders`, `/account/invoices`, `/account/downloads` and `/account/licenses`.

You can make your own version of the checkout pages in the builder. They use the same blocks: **Checkout Form**, **Order Review**, **Order Status**, **My Orders**, **My Invoices**, **My Downloads** and **My Licences**. Make an entry in the Checkout Pages collection with the slug `checkout`, `review` or `done`. **Order Status** can say the outcome as the page's main heading, so that page needs none of its own. These blocks lay themselves out in two columns when they have the room.

## Test mode

Until a site goes live, every checkout page says it's in test mode, each invoice is marked as no tax document and uses the `TEST-` series, and each mail says no real money moved. If the seller's address is still empty, the pages say that real sales stay closed until it's filled in. A public site's test checkout is for the team only, so a stranger can't get what's on sale for free.

To try a business sale without anyone's real VAT number, use zeros and one of the EU's [test codes](https://ec.europa.eu/taxation_customs/vies/#/technical-information): `DE000000100` is valid, `DE000000200` invalid and `DE000000300` means the service is down. Only test mode sends these to the EU's test service, and a live site only asks the real register.

## Go live

**Commerce → Go Live** lists what stands between you and real money, and **Go Live** is refused until nothing does:

- a licence for Commerce on this site's public address, added on the **Licence** screen
- company details: legal name, address, country, email and, for EU VAT, a VAT number
- a tax regime, which you have to choose
- a payment provider with live keys
- working email, because invoices go out by email
- when you [run a store](#run-a-store): live signing keys, an `https://` address, public accounts turned on, and payouts later than the refund window

Nothing fills in your company details for you. You can type them under **Settings → Commerce**, or name a global there whose fields have the same names. A site where a required field later goes empty stops taking new orders until it's filled in, and raises an alert. Payments already made still settle.

The licence is checked only here, once. **After a site has gone live, no failed, lapsed or missing licence ever stops it selling.** The check isn't there to fail: nothing in the checkout reads the licence.

## Stripe

Choose Stripe under **Settings → Commerce**, and add your keys. A restricted key (`rk_live_…`) is best. Then add a webhook endpoint in Stripe's dashboard, and copy its signing secret into the settings:

| Mode | Endpoint |
|---|---|
| Test | `https://your-site.example/api/commerce/webhooks/stripe/test` |
| Live | `https://your-site.example/api/commerce/webhooks/stripe/live` |

Send these events:

```
checkout.session.completed            checkout.session.expired
checkout.session.async_payment_succeeded  checkout.session.async_payment_failed
invoice.paid  invoice.payment_failed  invoice.payment_action_required  invoice.voided  invoice.upcoming
customer.subscription.updated  customer.subscription.deleted  customer.subscription.paused
refund.created  refund.updated  refund.failed  charge.refunded
charge.dispute.created  charge.dispute.updated  charge.dispute.closed
```

In Stripe's settings, turn off its own emails for successful payments and refunds, since your invoices are the legal documents. Set failed subscription payments to cancel the subscription after the retries, and set **Stripe Retry Window** in the settings to the same number of days.

No webhook is lost for good: a sale also settles when the buyer returns, and missed events are picked up hourly. There's nothing to run on your server. Follow-up work happens after requests. If you do have cron, `php cms commerce:work` keeps things moving on a quiet site.

## VAT

With **EU VAT** chosen, every sale gets one of these:

| Buyer | VAT | On the invoice |
|---|---|---|
| Consumer in your country | Your rate | |
| Business in your country, with a VAT number | Your rate | |
| Business elsewhere in the EU, number valid in VIES | None | Reverse charge |
| Business elsewhere in the EU, no number or not valid | As a consumer there | |
| Consumer elsewhere in the EU, you're registered for OSS | Their country's rate | |
| Consumer elsewhere in the EU, not registered, under EUR 10,000 a year | Your rate | |
| Business outside the EU | None | Outside the scope of VAT |
| Consumer outside the EU | Not sold, unless you choose otherwise | |

Past the EUR 10,000 limit without OSS, sales to consumers in other EU countries stop and you get an alert, until you register and turn on **Registered for OSS**. Sales outside this site count too: add them under **Cross-Border Sales Elsewhere**.

If VIES is down at checkout, the buyer pays VAT and it's refunded by itself once the number checks out, with a credit note and a new invoice. **Commerce → VAT** gives you each quarter's figures: OSS per country and rate, domestic sales, the reverse-charge listing and sales outside scope, with a CSV download. Credit notes count in the quarter they're issued and name the quarter they correct.

Rates are in the plugin, per country and date. A seller outside the EU chooses **No Tax**, and another tax system is another `TaxResolver`; see [Gateways and hooks](/plugins/commerce).

This is software, not tax advice. Your accountant decides what applies to you.

## Invoices

Each paid order gets a numbered invoice, sent by email as a PDF. Numbers run per year with no gaps, and a test order uses a separate `TEST-` series that never touches them. Refunds get a credit note in a `CN-` series, at the rate of the original invoice. A document is never changed afterwards: to fix one, refund it or correct it, so a credit note and a new invoice are issued. Names and addresses go on the invoice, so the checkout asks for them in Latin letters.

## Refunds

Refund from an order in the admin: everything left, one line, or an amount. A refund of everything, or of a line, takes back what it gave. An amount is a goodwill credit, and the buyer keeps what they bought. The credit note goes out once the provider confirms. A refund you make in the provider's dashboard is handled the same way.

Consumers can withdraw themselves from the order page for 14 days, as the law gives them, unless they agreed at checkout to immediate delivery of a product that says so. **Refund Window** lengthens this, and extends it to businesses. A business that has had **Refunds per Business, per Year** gets sent to you instead.

A dispute changes nothing for the buyer while it's open, and it blocks refunds, since the bank has taken the money already. If it's lost, what the order gave is taken back and that buyer can't buy until you mark it settled. Whether the VAT comes back is for you to review, so no credit note goes out by itself.

## Subscriptions

A product with a recurring price sells as a subscription, on its own. The payment provider runs the schedule and the retries, so a renewal never depends on someone visiting your site. Each renewal gets its own invoice, with VAT worked out for that moment.

When a payment fails, the buyer keeps access through the retries and gets an email. If the retries run out, the subscription ends and the access goes. Buyers cancel from their order page and keep what they paid for until the term ends.

## Peppol

Belgian businesses have to receive structured invoices. Turn on **Send E-Invoices over Peppol**, and add your access point's keys: the plugin speaks to [Recommand](https://recommand.eu), and another provider takes one small class. For a Belgian buyer with a VAT number, the invoice then goes as Peppol BIS Billing 3.0 UBL, as well as the PDF.

If they aren't on the network, the checkout asks them to accept PDF by email, and records it. A refused document stays valid and raises an alert, and you can resend it after fixing it. One that may or may not have gone out is never sent again by itself. Change **Peppol Country Pairs** when another country's law asks for the same.

## Licences

Sell something that runs on someone else's site, and a licence comes with it. On a product, turn on **Comes With a Licence** and say what it licenses: the package name its key is checked against, how many months of updates it includes, and how many domains one site may have, for a site in several languages. A licence is one-off and per site, so it can't be sold by subscription.

The buyer finds it at `/account/licenses`. They add their site's domain there and get a key to paste into their site. Subdomains and subfolders are covered, `www` included, and local and staging addresses need no licence at all. What counts as one domain comes from the [Public Suffix List](https://publicsuffix.org), so `client.example.co.uk` falls under `example.co.uk`, while `alice.github.io` is a site of its own. The plugin carries a copy, which `php tools/public-suffixes.php` in the workspace refreshes. A site holds one key, so when the same person activates a second product on a domain they already use, it joins that licence and the site's next daily refresh brings it in. Everything else is self-service as well:

- **Move a domain.** The old address keeps working for 30 days, so a migration can overlap. Three moves in 90 days, then they ask you.
- **Hand it over or sell it on.** The recipient accepts from a link sent to their address, then the owner has 72 hours to object, in case their account was taken over. A handover keeps the old owner as a manager until the new one removes them. A resale clears the domains, unless the site went with it, and stops the seller's key.
- **Extend updates.** A separate product whose sale extends: time left is kept, and a late extension owes nothing for the gap.
- **Replace the key,** if it leaked.

A refund or a lost chargeback marks only that product's entry on the licence, and a chargeback that's won puts it back. A voluntary refund stops once a licence has been transferred; the law's 14 days don't. Whatever happens to a licence, the site keeps running: the most any state does is a banner in its admin.

**Commerce → Licences** shows who holds what. You can issue one by hand for a deal made elsewhere, send a notice, revoke after that notice runs out, or move a licence to someone who has proved they control the site, when its owner is gone. Someone who bought a domain from the old owner can prove it from their account, with a DNS record or a file, and the proof decides who holds it. A key only ever says what it covers: it holds no name and no address.

## Run a store

Turn on **Run a Store** under **Settings → Commerce**, and your site becomes a store: the `/store` shelf with search and filters, a page per listing, and the [store protocol](/plugins/store-protocol) at `/api/store/v1`, which other sites read from **Modules → Store**. It sells anything. A plugin is installed from the buyer's admin, or with Composer. A file is downloaded from their account. To shape the shelf in the builder, use the **Store** and **Store Item** blocks, or the **Store Items** data source with a Repeat block: a page of yours at `/store` wins over the standard one, and is written again when the store changes. Its items have `title`, `summary`, `url`, `image`, `category`, `cost`, `price`, `price_line`, `by`, `label` and more; if you list them, add the **Store Ranking** block too. For your own item page, make a Checkout Pages entry with the slug `store-item` and bind to `entry.listing`: `price`, `price_note`, `vat_line`, `buy_url`, `screenshots`, `description_html`, `versions`, `requirements`, `docs_url`, `by`, `seller` and more.

Under **Commerce → Store**, add a listing, set a price and a price for more updates, and publish a version. A listing also has screenshots, what it needs to run and a link to its documentation:

```bash
php cms commerce:store-publish acme/forms dist/acme-forms-1.2.0.zip --notes="Fixes saving"
```

Each version is signed, and a version number is never used twice. Going on sale needs a published version and a price. New prices are for new sales. Delisting stops new sales, while what's been sold keeps working and can still be extended. A free listing stays free once it's out. **Block** withdraws versions for a security reason: sites refuse them everywhere and warn their admins, and nothing installed is switched off.

A paid download goes out only if the licence is live right now and covers that site's domain and that version's release date. That's decided on your server, from your own records, so a refund shuts it at once, whatever an older key still says. A version marked as a security fix goes to anyone who ever held the package, for the domain their key names. **Free Download for Local Sites** lets anyone who says they're on a local address fetch a paid plugin, so it's off unless you turn it on.

### Keys

In test mode a store makes its own keys. Going live needs real ones, which sites will trust from then on. `php cms commerce:store-keys init --mode=live` makes them and shows you the root key once: it's kept nowhere, so store it offline. Or make them elsewhere and bring them in with `import`, so the root never touches the server. The two working keys stay on the server, encrypted with `APP_KEY`, because signing happens there. Publish the fingerprint, so people adding your store can compare it.

### Authors

Others sell in your store by invitation. Under **Commerce → Store**, invite someone. The link works once, for that address, for 14 days. They choose a vendor name, which all their packages start with, and work from `/account/store`: listings, uploads and earnings. They set up payouts on the payment provider's own page, so nothing of theirs reaches your server, and a listing can't go on sale until they can be paid.

Nothing an author does reaches a buyer without you. Each version waits for your review, where the scan lists what its code can do and points at lines worth reading. That's a filter, not a proof: a plugin runs with full access to a site, and your approval is what signs it. A price waits for you too.

You sell to the buyer, on your own invoice, and pay the author. The author gets the price without VAT, less **Store Commission** (15% unless you change it, per sale at the rate of that day), **31 days** after the sale, with **Days Before an Author Is Paid** set above your refund window. Set **Refund Window** to 30 days to match. What's due is added up per author and sent in one transfer, in the background. A refund or chargeback takes back the author's share: before the payout it simply comes off, and after it, it's set against their next one. A sale under dispute waits, and so does a suspended author's money. Payouts need a provider that can pay others, which with Stripe means Connect: turn it on in Stripe's dashboard.

Items on the shelf are ordered by downloads over the last 90 days, then the most recent release. A search matches the title first, then the summary and categories. **Featured** adds a label, and a page of yours can show featured items first. Nobody can pay for a higher place, and the shelf says so.

## Permissions

`commerce.view` sees orders and sales. `commerce.manage` adds products, refunds and going live. Customer data and money never reach the assistant or MCP.
