---
id: 01m6rrkkgj90wstepzbeam9h72
title: Commerce gateways and hooks
position: 8
description: React to what was sold, sell at a price you worked out, or add a payment gateway, a tax service or an e-invoicing channel.
---
[Commerce](/operations/commerce) takes payments, issues invoices and handles VAT, but it knows nothing about what you sell. Your plugin fills that in: it can give buyers what they paid for, sell at a price it works out itself, or add a new way to pay. None of it needs a change to Commerce.

## Give buyers what they paid for

Commerce keeps an **entitlement** for each paid line: a record that this buyer has this product. It tells you when one is granted or taken back, and you decide what that means:

```php
cms()->hooks()->on('commerce.entitlement.granted', function (EntitlementEvent $e) {
    MyThing::give($e->email, $e->sku, until: $e->periodEnd, because: $e->context);
});

cms()->hooks()->on('commerce.entitlement.revoked', function (EntitlementEvent $e) {
    MyThing::takeBack($e->sku, $e->orderId, reason: $e->reason);
});
```

Events arrive after the sale has committed, at least once. A listener that throws is tried again later, without touching the sale. So dedupe on `$event->id`, which stays the same across retries.

`Cms\Commerce\Orders\EntitlementEvent` carries `id`, `type`, `entitlementId`, `sku`, `orderId`, `lineId`, `userId`, `email`, `mode`, `reason`, `periodEnd` and `context` (what the checkout carried, for example from a [signed cart](#sell-at-your-own-price)).

::: callout {"props":{"tone":"tip","text":"For a product that only opens gated content, you need no code: name the access on the product. A product with license terms issues its <a href=\"/operations/commerce#licenses\">license</a> the same way."}}
:::

### Every Commerce hook

| Hook | Kind | Arguments | When |
|---|---|---|---|
| `commerce.entitlement.granted` | action | `$event` | Paid, renewed, or in grace after a failed renewal (`reason: grace`, `periodEnd` is when it ends). |
| `commerce.entitlement.revoked` | action | `$event` | `reason` is `refunded`, `withdrawal`, `charged_back`, `canceled`, `ended` or another a plugin gave. |
| `commerce.entitlement.restored` | action | `$event` | A lost chargeback was reversed. |
| `commerce.order.paid` | action | `$order` | Inside the transaction. Throwing undoes the sale, so keep to the entitlement hooks unless you mean that. |
| `commerce.order.refunded` | action | `$order, $refund` | Inside the transaction too. |
| `commerce.refund.refusal` | filter | `$refusal, $order` | Return a sentence to stop a voluntary refund. The consumer's statutory 14 days don't pass through here. |
| `commerce.alert` | action | `$code, $severity, $message, $subject` | Something needs a person. |
| `commerce.line.adjust` | filter | `$line, $product, $buyer` | Change a line before it's priced into a quote. |
| `commerce.can_purchase` | filter | `$refusal, $product, $buyer` | Return a sentence to refuse a sale. |
| `commerce.vat_rates` | filter | `$rates` | Add or change rates, per country and date. |

## Sell at your own price

A browser can't set a price. A signed cart can, because only your server can make one. Use it for an upgrade, a quote or anything priced on the fly:

```php
use Cms\Commerce\Checkout\Carts;

$url = Carts::url(Carts::sign([[
    'sku' => 'pro',
    'name' => 'Upgrade to Pro',
    'unit_minor' => 12000,                 // cents
    'context' => ['upgrade_from' => $id],  // comes back on the event
]], validForSeconds: 86_400));
```

The link goes to the normal checkout, so VAT and the invoice work as usual.

## Add a payment gateway

Implement `Cms\Commerce\Gateways\PaymentGateway` and register it. It's then a choice of **Payment Gateway** on Commerce's **Settings** tab.

```php
cms()->whenAvailable(Gateways::class, fn (Gateways $g) => $g->register('acme', fn () => new AcmeGateway));
```

### Four rules

These keep every gateway swappable:

- **A webhook is a hint.** `verifyWebhook()` authenticates and says which resources it's about. It changes nothing. Commerce then calls `fetch()`, and only that answer changes an order. A gateway with unsigned, id-only webhooks returns `authenticated: false`, and Commerce only acts on references it already knows.
- **It sees only a gross amount.** A payment carries no tax details, and returns none. A gateway that also works out tax does it [apart from the payment](#work-out-tax-outside-the-eu).
- **It never issues the legal document.** Commerce does, the same for every gateway.
- **It's always a redirect.** `startCheckout()` returns a hosted page's address, and `capabilities()->checkoutHosts` lists its hosts for the page's content security policy.

### Retries and errors

`startCheckout()`, `refund()` and the subscription calls get a key that's the same on a retry, with the same body. Throw:

| Exception | When |
|---|---|
| `GatewayUnknownOutcome` | The call may have worked (a timeout, a 5xx). Commerce looks it up with `findByLocalId()`, or retries with the same key, never a new one. |
| `GatewayUnavailable` | It surely didn't go through. |
| `GatewayRejected` | The gateway refused. |

### Webhooks and going live

Webhooks reach you at `POST /api/commerce/webhooks/{gateway}/{mode}`, each mode with its own address. `changesSince()` is the catch-up for missed ones.

Return `liveAllowed: false` from `capabilities()` for anything that takes no real money: going live refuses it.

### The interface

| Method | Does |
|---|---|
| `id()`, `label()` | Who it is. |
| `capabilities($mode)`, `diagnose($mode)` | What it can do, and whether its keys are in place and it answers (checked before going live). |
| `startCheckout()`, `cancelCheckout()` | Open and cancel a hosted checkout. |
| `verifyWebhook()`, `fetch()`, `findByLocalId()`, `changesSince()` | Learn what happened, as above. |
| `updateSubscriptionAmount()`, `cancelSubscription()`, `resumeSubscription()` | Subscriptions. |
| `refund()` | Refund a payment. |
| `customerActionUrl()`, `dashboardUrl()` | A hosted page where a customer changes their payment method, and a link to a resource in the gateway's dashboard for admins. Either may be `null`. |

## Work out tax outside the EU

A gateway that also offers a tax service implements `Cms\Commerce\Tax\TaxService`. When **Buyers Outside the EU** is set to the gateway's tax, Commerce prices every sale to a buyer outside the EU through it. EU VAT never does.

- **`calculate()`** gets a `TaxRequest`: the buyer's country, postal code, city and address line, whether they're a business and their tax number, and the lines in minor units. Lines are before tax, or include it when `inclusive` is set, as for a renewal already charged. It answers with a `TaxCalculation`: the exact tax, the rate in basis points, the service's own rate and the tax's type when there's one, and whether it's a reverse charge. Throw `GatewayRejected` for an address or number it can't place, and the buyer is asked to check it. Throw `GatewayUnavailable` or `GatewayUnknownOutcome` when it can't be asked. The same request is asked once per 30 minutes.
- **`record()`** is called once the sale is paid, with the calculation and the order number. **`reverse()`** is called for each refund, with the amount refunded, tax included. Both run in the background and are tried again, so they must be safe to repeat under the same reference.
- **`taxProblems()`** lists what stops it working with real money. The **Go Live** page shows it.

Stripe's driver does this with Stripe Tax's calculations and transactions.

## Add an e-invoicing channel

Implement `Cms\Commerce\Transports\InvoiceTransport`, and call `app(Transports::class)->register($transport)`. It says which buyers it covers and whether it can reach them, and sends the frozen document. Everyone also gets the PDF by email, whatever the channel.

To use another Peppol provider, bind your own `Cms\Commerce\Transports\Peppol\AccessPoint`; UBL and the flow stay as they are.

## Another tax system

Bind your own `Cms\Commerce\Tax\TaxResolver`. It takes a `TaxContext` and answers with a `TaxDecision`: a rate, a scheme, a category and what the invoice must say.
