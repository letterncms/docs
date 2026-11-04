---
id: 01m6rrkkgj90wstepzbeam9h71
title: Selling with Commerce
position: 8
description: Sell downloads, courses, memberships or anything else from your site, with proper invoices, EU VAT and refunds taken care of.
---
Commerce lets a site sell: a download, a course, a membership, a voucher, anything you add as a product. Buyers pay on the payment provider's own page, so card details never touch your site. You get numbered invoices, VAT worked out per buyer, refunds and subscriptions, whichever provider you use.

![Commerce: the orders, with their buyers, status and totals.](/media/screens/operations-commerce.webp)

Commerce is a paid plugin from the store. You can set it up and try every sale in test mode before buying a license.

## Sell something

1. Open **Commerce**, then **Products**, and press **New Product**: give it a **Name**, an **SKU** (a short code for it, like `voucher`) and a **Price**.
2. Under **VAT**, choose **Included** if everyone pays that price, VAT and all, or **Not Included** to add VAT on top. Under **Billing**, choose **One-Off**, **Every Month** or **Every Year**.
3. Say what the buyer gets. Upload a **File to Deliver**, and they get a download link for as long as their purchase stands. Or fill in **Gives Access To**, like `magazine`, and they can read your [members-only pages](/content/gated-content) with that access. Both are taken back by themselves after a refund.
4. Put a **Products** or **Buy Button** block on any page.

Buyers become [visitor accounts](/operations/public-accounts) on your site, with no access to the admin.

## What your buyer sees

1. The buyer fills in who they are and where.
2. They see the exact total, with VAT.
3. They pay on the payment provider's page.
4. They come back to an order page that says how it went, with the invoice and the downloads. A link to it goes by email.

If the payment fails, the page says nothing was charged and offers another try. Customers with an account also find everything under their account: orders, invoices, downloads and licenses.

You can design your own versions of these pages in the builder. See [For developers](#your-own-checkout-pages).

## Try it in test mode

Commerce starts in test mode, with no license and no account anywhere. A built-in sandbox stands in for the payment provider, with **Pay** and **Decline** buttons, so you can try a whole sale.

In test mode, a line across the top of Commerce's screens says **Test mode: no real money moves.**, every checkout page says so too, invoices are marked as not being tax documents and use a separate `TEST-` series, and each email says no real money moved. While your company's address is still empty, the pages say real sales stay closed until it's filled in. On a public site, only your team can use the test checkout, so a stranger can't get what's on sale for free.

## Go live

Press **Go Live** in the test-mode line at the top of Commerce. The **Go Live** page lists what stands between you and real money, each with a button to the setting or screen that settles it, and **Go Live** works once nothing does:

- a license for Commerce on this site's public address, added under **Plugins → Licenses**;
- your company details: legal name, address, country, email and, for EU VAT, a VAT number;
- a **Tax Regime**, which you have to choose;
- a payment provider with live keys;
- when **Buyers Outside the EU** uses the payment gateway's tax: a tax service that works, which for Stripe means a head office address in [Stripe Tax](#stripe-tax);
- [working email](/operations/email), because invoices go out by email;
- when you [run a store](#run-a-store): live signing keys, an `https://` address and [visitor accounts](/operations/public-accounts) turned on.

Fill in your company details on Commerce's **Settings** tab, under **Seller**, or under **Company Details From a Global** name a global whose fields have the same names. Nothing fills them in for you. If a required detail later goes empty, the site stops taking new orders and raises an alert until it's filled in again. Payments already made still settle.

Once you're live, **Live** in Commerce's top bar opens the same page, with **Back to Test Mode** and the webhook addresses.

::: callout {"props":{"tone":"tip","text":"The license is checked once, when you go live. <strong>After that, no failed, lapsed or missing license ever stops a site selling.</strong> Nothing in the checkout reads it."}}
:::

## Connect Stripe

1. On Commerce's **Settings** tab, set **Payment Gateway** to Stripe.
2. Under **Stripe**, add your secret keys. A restricted key (`rk_live_…`) is best. With [Stripe Tax](#stripe-tax), it also needs to write tax calculations and transactions and read tax settings.
3. In Stripe's dashboard, add a webhook endpoint, choose the events [listed below](#stripe-webhooks), and copy its signing secret into the settings. The **Go Live** page lists both addresses to copy:

| Mode | Endpoint |
|---|---|
| Test | `https://your-site.example/api/commerce/webhooks/stripe/test` |
| Live | `https://your-site.example/api/commerce/webhooks/stripe/live` |

4. In Stripe's settings, turn off its own emails for successful payments and refunds: your invoices are the legal documents.
5. Set failed subscription payments to cancel the subscription after the retries, and set **Retry Window**, under **Stripe**, to the same number of days.

No sale is lost if a webhook is: a sale also settles when the buyer returns, and missed events are picked up every hour.

### Stripe Tax

Outside the EU, tax rates change by country, state and city, and what you collect depends on where you're registered. Stripe Tax keeps track of both. To use it:

1. In Stripe, open **Tax → Settings**. Add your head office address, and set the preset product tax code to what you sell, such as software.
2. Under **Tax → Registrations**, add each place you're registered outside the EU, such as the UK, Switzerland or a US state.
3. On Commerce's **Settings** tab, set **Buyers Outside the EU** to **Tax From the Payment Gateway, Like Stripe Tax**.

Commerce then asks Stripe Tax for the tax on each buyer's address and lines, and charges exactly that. The same figure is on the order summary, the payment and the invoice, which names the tax and its rate as Stripe does: sales tax at 8.875%, GST at 10%. Where you aren't registered, the tax is zero and the sale goes ahead. A business that gives its tax number is reverse charged where that applies.

Each paid sale is recorded in Stripe Tax under its order number, and each refund takes its share back, so Stripe's reports, filings and threshold monitoring cover every sale. Its monitoring points out where you may need to register next; your accountant decides. Buyers in the EU are never sent to Stripe Tax. Stripe charges for Stripe Tax per transaction where you're registered; see its [pricing](https://stripe.com/tax/pricing).

## VAT

Choose the **Tax Regime** on Commerce's **Settings** tab: **EU VAT**, **EU Small Business, Exempt**, or **No Tax (Seller Outside the EU)**. With **EU VAT**, every sale gets one of these:

| Buyer | VAT | On the invoice |
|---|---|---|
| Consumer in your country | Your rate | |
| Business in your country, with a VAT number | Your rate | |
| Business elsewhere in the EU, number valid in VIES | None | Reverse charge |
| Business elsewhere in the EU, no number or not valid | As a consumer there | |
| Consumer elsewhere in the EU, you're registered for OSS | Their country's rate | |
| Consumer elsewhere in the EU, not registered, under EUR 10,000 a year | Your rate | |
| Business outside the EU | None, or what [Stripe Tax](#stripe-tax) works out | Outside the scope of VAT, or reverse charge |
| Consumer outside the EU | Not sold, sold without tax, or what Stripe Tax works out | |

**Buyers Outside the EU** decides the last two rows: **Businesses Only, Without Tax** (the default), **Everyone, Without Tax**, or **Tax From the Payment Gateway, Like Stripe Tax**. A gateway that can't work out tax sells as with the default.

Past the EUR 10,000 limit without OSS (the EU's One Stop Shop), sales to consumers in other EU countries stop and you get an alert, until you register and turn on **Registered for OSS**. Sales outside this site count too: add them, in euros, under **Cross-Border Sales Elsewhere**.

If VIES, the EU's VAT number check, is down at checkout, the buyer pays VAT. It's refunded by itself once the number checks out, with a credit note and a new invoice.

**Commerce → VAT** gives you each quarter's figures: OSS per country and rate, domestic sales, the reverse-charge listing, sales outside scope and, under **Tax Abroad**, what Stripe Tax priced, per country, with a CSV download. Credit notes count in the quarter they're issued and name the quarter they correct.

This is software, not tax advice. Your accountant decides what applies to you.

## Invoices

Each paid order gets a numbered invoice, sent by email as a PDF. Numbers run per year with no gaps. Refunds get a credit note in a `CN-` series, at the rate of the original invoice.

An invoice is never changed afterward. To fix one, refund it or correct it, and a credit note and a new invoice are issued. Names and addresses go on the invoice, so the checkout asks for them in Latin letters.

## Orders paid by bank transfer

Some buyers, often businesses, need an invoice before they can pay. For them, you write the order yourself: it waits, unpaid, until you send the invoice.

1. Create the order with the buyer's details and its lines (see [For developers](#manual-orders)).
2. Open it under **Commerce** and press **Issue Invoice**. The buyer gets the invoice, due after the **Bank Transfer Terms** (30 days by default).
3. When the money arrives, press **Mark as Paid** and enter the **Bank Reference**.

Such an order grants nothing by default, because a deal like this is usually delivered by hand.

## Discounts

Under **Commerce → Discounts**, press **New Discount** and give it a **Percentage**, or **Or an Amount**. It can need a **Code**, be **Only for This Email**, start **After This Many Purchases**, or end on a date (**Ends On**). When more than one applies, the best one wins; they don't add up.

## Refunds

Open an order and press **Refund**. A **Full Refund** of everything left, or of one item, takes back what it gave the buyer. A **Custom Amount**, as goodwill, leaves them what they bought.

The credit note goes out once the provider confirms. A refund you make in the provider's dashboard is handled the same way.

Consumers can withdraw themselves from their order page for 14 days, as the law gives them, unless they agreed at checkout to immediate delivery of a product that allows it (**Right to Withdraw** on the product: **Ends on Delivery, With Consent**). **Refund Window** lengthens this, and extends it to businesses. A business that has used up **Refunds per Business, per Year** is sent to you instead.

A dispute (a chargeback) changes nothing for the buyer while it's open, and blocks refunds, since the bank has taken the money already. If it's lost, what the order gave is taken back and that buyer can't buy until you press **Mark as Settled**. Whether the VAT comes back is for you to review, so no credit note goes out by itself.

## Subscriptions

A product billed every month or year sells as a subscription. The payment provider runs the schedule and the retries, so a renewal never depends on someone visiting your site. Each renewal gets its own invoice, with VAT worked out for that moment.

When a payment fails, the buyer keeps access through the retries and gets an email. If the retries run out, the subscription ends and the access goes. Buyers cancel from their order page, and keep what they paid for until the term ends.

## Peppol e-invoices

Belgian businesses have to receive structured invoices. Turn on **Send E-Invoices over Peppol** and add your access point's keys: the plugin works with [Recommand](https://recommand.eu). For a Belgian buyer with a VAT number, the invoice then also goes out as Peppol BIS Billing 3.0 UBL, as well as the PDF.

If the buyer isn't on the network, the checkout asks them to accept a PDF by email, and records it. A refused invoice stays valid and raises an alert, and you can resend it after fixing it. One that may or may not have gone out is never sent again by itself. Change **Country Pairs** when another country's law asks for the same.

## Licenses

Sell something that runs on someone else's site, like a plugin, and a license comes with it. On the product, turn on **Comes With a License** and fill in the **Licensed Product** (the package name its key is checked against), the **Months of Updates** it includes, and the **Domains per Site**, for a site in several languages. A license is one-off and per site, so it can't be sold by subscription.

The buyer adds their site's domain under their account and gets a key to paste into their site. Subdomains and subfolders are covered, `www` included, and local and staging addresses need no license at all. A site holds one key: when the same person activates a second product on a domain they already use, it joins that license. Everything else is self-service too:

- **Move a domain.** The old address keeps working for 30 days, so a migration can overlap. Three moves in 90 days, then they ask you.
- **Hand it over or sell it on.** The recipient accepts from a link sent to their address, then the owner has 72 hours to object, in case their account was taken over. A handover keeps the old owner as a manager until the new one removes them. A resale clears the domains, unless the site went with it, and stops the seller's key.
- **Extend updates.** A separate product whose sale extends a license: time left is kept, and a late extension owes nothing for the gap.
- **Replace the key,** if it leaked.

A refund or a lost chargeback marks only that product's entry on the license, and a chargeback that's won puts it back. A voluntary refund stops once a license has been transferred; the law's 14 days don't. Whatever happens to a license, the site keeps running: the most any state does is a banner in its admin.

**Commerce → Licenses** shows who holds what. **Issue License** issues one by hand for a deal made elsewhere. On a license you can **Send Notice**, **Revoke License** after that notice runs out, or **Move to Someone Else** for someone who has proved they control the site when its owner is gone. Someone who bought a domain from the old owner can prove it from their account, with a DNS record or a file. A key only ever says what it covers: it holds no name and no address.

## Run a store

Turn on **Run a Store** on Commerce's **Settings** tab, and your site becomes a store that other Lettern sites can install from: a `/store` shelf with search and filters, and a page per listing. It sells anything: a plugin is installed from the buyer's admin under **Plugins → Store**, or with Composer, and a file is downloaded from their account.

While the store is on, **Store** in Commerce's top bar opens it. Press **New Listing** to add one, with screenshots, what it needs to run and a link to its documentation. Set a price and a price for more updates, and publish a version. Going on sale needs a published version and a price.

- New prices are for new sales. A free listing stays free once it's out.
- **Delist It** stops new sales, while what's been sold keeps working and can still be extended.
- Blocking withdraws versions for a security reason: sites refuse them everywhere and warn their admins, and nothing installed is switched off.
- **Featured** adds a label. Nobody can pay for a higher place, and the shelf says so: items are ordered by downloads over the last 90 days, then the most recent release.

A paid download goes out only if the license is live right now and covers that site's domain and that version's release date. That's decided on your server, from your own records, so a refund shuts it at once. A version marked as a security fix goes to anyone who ever held the package. **Free Download for Local Sites** lets anyone who says they're on a local address fetch a paid plugin, so it's off unless you turn it on.

### Authors

Others publish in your store by invitation. On the store's page, press **Invite an Author**: the link works once, for that address, for 14 days. They choose a vendor name, which all their packages start with, and work from `/account/store`. What an author lists is free. Only you sell, so nobody else is paid through your store.

Nothing an author makes reaches a site without you. Each version waits for your review, where a scan lists what its code can do and points at lines worth reading. That's a filter, not a proof: a plugin runs with full access to a site, and your approval is what signs it. Suspending an author delists their listings, and copies already installed keep working.

## For developers

### Your own checkout pages

The checkout pages are built from blocks: **Checkout Form**, **Order Review**, **Order Status**, **My Orders**, **My Invoices**, **My Downloads** and **My Licenses**. To design your own, open **Pages**: under **Built-in Pages**, **Commerce** lists *Checkout* (`/checkout`), *Review your order* (`/checkout/review`) and *Your order* (`/checkout/done`). Press **Customize** beside one to make it a page of your own, and publish it to take over from the standard one. **Order Status** can say the outcome as the page's main heading, so that page needs none of its own. These blocks lay themselves out in two columns when they have the room.

The addresses: products link to `/checkout?product=<sku>`, the order page is `/checkout/done`, and customers' pages are `/account/orders`, `/account/invoices`, `/account/downloads` and `/account/licenses`.

### Stripe webhooks

Send these events to the endpoint:

```
checkout.session.completed            checkout.session.expired
checkout.session.async_payment_succeeded  checkout.session.async_payment_failed
invoice.paid  invoice.payment_failed  invoice.payment_action_required  invoice.voided  invoice.upcoming
customer.subscription.updated  customer.subscription.deleted  customer.subscription.paused
refund.created  refund.updated  refund.failed  charge.refunded
charge.dispute.created  charge.dispute.updated  charge.dispute.closed
```

### Background work

Nothing needs to run on your server: follow-up work happens after requests. If you have cron, `php cms commerce:work` keeps things moving on a quiet site.

### Testing VAT numbers

To try a business sale without a real VAT number, use zeros and one of the EU's [test codes](https://ec.europa.eu/taxation_customs/vies/#/technical-information): `DE000000100` is valid, `DE000000200` invalid, and `DE000000300` means the service is down. Only test mode sends these to the EU's test service; a live site only asks the real register.

### Tax and invoicing extensions

VAT rates are in the plugin, per country and date. Another tax system is another `TaxResolver`, and another Peppol access point takes one small class. See [Commerce gateways and hooks](/plugins/commerce).

### License domains

What counts as one domain comes from the [Public Suffix List](https://publicsuffix.org), so `client.example.co.uk` falls under `example.co.uk`, while `alice.github.io` is a site of its own. The plugin carries a copy. A site that activates a second product on a domain it already uses picks it up on its next daily refresh.

### Store shelf and listing pages

The [store protocol](/plugins/store-protocol) is served at `/api/store/v1`. To shape the shelf in the builder, use the **Store** and **Store Item** blocks, or the **Store Items** data source with a Repeat block. A page of yours at `/store` wins over the standard one, and is written again when the store changes. Its items have `title`, `summary`, `url`, `image`, `category`, `cost`, `price`, `price_line`, `by`, `label` and more. If you list them, add the **Store Ranking** block too.

While the store is on, **Built-in Pages** also lists *Store* and *Store Item*. Customize *Store Item* for your own item page, and bind to `entry.listing`: `price`, `price_note`, `vat_line`, `buy_url`, `screenshots`, `description_html`, `versions`, `requirements`, `docs_url`, `by`, `seller` and more.

Publish a version from the command line:

```bash
php cms commerce:store-publish acme/forms dist/acme-forms-1.2.0.zip --notes="Fixes saving"
```

Each version is signed, and a version number is never used twice.

### Store keys

In test mode a store makes its own signing keys. Going live needs real ones, which sites will trust from then on. `php cms commerce:store-keys init --mode=live` makes them and shows you the root key once: it's kept nowhere, so store it offline. Or make them elsewhere and bring them in with `import`, so the root never touches the server. The two working keys stay on the server, encrypted with `APP_KEY`, because signing happens there. Publish the fingerprint, so people adding your store can compare it.

### Manual orders

The `commerce/orders.create-manual` ability (REST or the command line, `commerce.manage`) creates an order paid by bank transfer, from a `buyer` (email and country required) and its `lines` (`name`, `unit_minor`, optional `sku`, `quantity` and `grants_entitlement`, which is off by default). The same rules and tax apply as at checkout. `commerce/orders.issue-invoice` and `commerce/orders.mark-paid` (with `bank_reference`) are the two buttons; `commerce/orders.cancel-invoice` credits an unpaid invoice in full and cancels the order.

### Permissions

`commerce.view` sees orders and sales. `commerce.manage` adds products, refunds and going live. Customer data and money never reach the assistant or MCP.
