---
id: 01m6rrkkgj90wstepzbeam9h72
title: Commerce gateways and hooks
position: 11
group: 'Build'
description: Register a payment gateway, react to what was sold, sell at a price you worked out, and add an e-invoicing channel.
---
[Commerce](/operations/commerce) knows nothing about what's sold or who pays for it. A plugin extends it in four places, and none needs a change to Commerce.

## React to a sale

Commerce doesn't know what a purchase means. It keeps an entitlement for each paid line and tells you when one changes:

```php
cms()->hooks()->on('commerce.entitlement.granted', function (EntitlementEvent $e) {
    MyThing::give($e->email, $e->sku, until: $e->periodEnd, because: $e->context);
});

cms()->hooks()->on('commerce.entitlement.revoked', function (EntitlementEvent $e) {
    MyThing::takeBack($e->sku, $e->orderId, reason: $e->reason);
});
```

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

Events arrive after the sale has committed, at least once, and a listener that throws is tried again later without touching the sale. So dedupe on `$event->id`, which stays the same across retries. For a product that only opens gated content, you need none of this: name the access on the product. A product with licence terms issues its [licence](/operations/commerce#licences) the same way, with no code.

## Sell at your own price

A browser can't set a price. A signed cart can, because only your server can make one:

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

## Register a gateway

Implement `Cms\Commerce\Gateways\PaymentGateway` and register it. It's then a choice under **Settings → Commerce**.

```php
cms()->whenAvailable(Gateways::class, fn (Gateways $g) => $g->register('acme', fn () => new AcmeGateway));
```

Four rules keep the contract swappable:

- **A webhook is a hint.** `verifyWebhook()` authenticates and says which resources it's about. It changes nothing. Commerce then calls `fetch()`, and only that answer changes an order. A gateway with unsigned, id-only webhooks returns `authenticated: false`, and Commerce only acts on references it already knows.
- **It sees only a gross amount.** It gets no tax details, and returns none.
- **It never issues the legal document.** Commerce does, the same for every gateway.
- **It's always a redirect.** `startCheckout()` returns a hosted page's address, and `capabilities()->checkoutHosts` lists its hosts for the page's content security policy.

`startCheckout()`, `refund()` and the subscription calls get a key that's the same on a retry, with the same body. Throw `GatewayUnknownOutcome` when a call may have worked (a timeout, a 5xx), `GatewayUnavailable` when it surely didn't go through, and `GatewayRejected` when the gateway refused. Commerce looks up an unknown outcome with `findByLocalId()`, or retries with the same key, and never with a new one.

Webhooks reach you at `POST /api/commerce/webhooks/{gateway}/{mode}`, each mode with its own address. `changesSince()` is the catch-up for missed ones. Return `liveAllowed: false` from `capabilities()` for anything that takes no real money: going live refuses it.

## Add an e-invoicing channel

Implement `Cms\Commerce\Transports\InvoiceTransport`, and call `app(Transports::class)->register($transport)`. It says which buyers it covers and whether it can reach them, and sends the frozen document. Everyone also gets the PDF by mail, whatever the channel. To use another Peppol provider, bind your own `Cms\Commerce\Transports\Peppol\AccessPoint`, and UBL and the flow stay as they are.

## Another tax system

Bind your own `Cms\Commerce\Tax\TaxResolver`. It takes a `TaxContext` and answers with a `TaxDecision`: a rate, a scheme, a category and what the invoice must say.
