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

::: box {"id":"d-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"d-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"d-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"},"xl":{"gridTemplateColumns":"6xl 1fr 6xl"}}}
::::: pattern {"id":"d-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"d-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"lg","paddingBottom":"3xl"},"lg":{"paddingTop":"xl"}},"anchor":"main"}
:::::: box {"id":"d-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"text","marginInline":"auto"}}}
::::::: pattern {"id":"d-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"d-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"xl","backgroundColor":"background-muted","borderRadius":"md","paddingInline":"md"},"xl":{"display":"none"}}}
:::::::: box {"id":"d-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"between","minHeight":"xl","fontSize":"sm","fontWeight":"medium","color":"foreground","cursor":"pointer"}}}
::::::::: paragraph {"id":"d-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"d-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"sm","height":"sm","color":"foreground-muted","transitionProperty":"transform","transitionDuration":"fast","transitionTimingFunction":"out"},"in-open":{"rotate":"180"}}}
:::::::::
::::::::

:::::::: repeat {"id":"d-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"style":{"base":{"display":"grid","paddingBottom":"sm"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"d-otp-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"}},"bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"d-body","label":"Body","style":{"base":{"flow":"prose"}}}
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
