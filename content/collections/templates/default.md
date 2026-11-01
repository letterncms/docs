---
id: 01m5x8wt57sd6qwb4pqmg9p9m9
title: 'Default'
status: published
published_at: '2026-10-26T23:31:55+00:00'
position: 1
description: 'Anything without its own template.'
created_at: '2026-10-26T23:31:55+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"d-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: pattern {"id":"d-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"d-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"},"xl":{"gridTemplateColumns":"14rem minmax(0, 1fr) 11.5rem"}}}
::::: pattern {"id":"d-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"d-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"1.5rem","paddingBottom":"5rem"},"lg":{"paddingTop":"2.5rem"}},"anchor":"main"}
:::::: box {"id":"d-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"token:container.prose","marginInline":"auto"}}}
::::::: pattern {"id":"d-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"d-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"2rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","paddingInline":"1rem"},"xl":{"display":"none"}},"class":"docs-otp"}
:::::::: box {"id":"d-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","minHeight":"2.75rem","fontSize":"token:text.sm","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"d-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"d-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: repeat {"id":"d-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"style":{"base":{"display":"grid","paddingBottom":"0.75rem"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"d-otp-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"}},"bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"d-body","label":"Body","class":"cms-prose"}
:::::::: outlet {"id":"d-outlet","props":{}}
::::::::
:::::::

::::::: pattern {"id":"d-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: pattern {"id":"d-toc","props":{"ref":"docs-toc"}}
:::::
::::

:::: pattern {"id":"d-footer","props":{"ref":"docs-footer"}}
::::
:::
