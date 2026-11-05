---
id: 01m5x8wr4cqfwcaq7aecq8traj
title: 'Documentation page'
status: published
published_at: '2026-10-26T23:31:53+00:00'
position: 0
description: 'The page with its head and prev/next, On this page, and a card for each page of a section.'
collections:
  - docs
created_at: '2026-10-26T23:31:53+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"t-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"t-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"t-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"},"xl":{"gridTemplateColumns":"6xl 1fr 6xl"}}}
::::: pattern {"id":"t-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"t-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"lg","paddingBottom":"3xl"},"lg":{"paddingTop":"xl"}},"anchor":"main"}
:::::: box {"id":"t-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"text","marginInline":"auto"}}}
::::::: pattern {"id":"t-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"t-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"xl","backgroundColor":"background-muted","borderRadius":"md","paddingInline":"md"},"xl":{"display":"none"}}}
:::::::: box {"id":"t-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"between","minHeight":"xl","fontSize":"sm","fontWeight":"medium","color":"foreground","cursor":"pointer"}}}
::::::::: paragraph {"id":"t-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"t-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"sm","height":"sm","color":"foreground-muted","transitionProperty":"transform","transitionDuration":"fast","transitionTimingFunction":"out"},"in-open":{"rotate":"180"}}}
:::::::::
::::::::

:::::::: repeat {"id":"t-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"style":{"base":{"display":"grid","paddingBottom":"sm"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"t-otp-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"}},"bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"t-body","label":"Body","style":{"base":{"flow":"prose"}}}
:::::::: outlet {"id":"t-outlet","props":{"permalinks":true}}
::::::::
:::::::

::::::: repeat {"id":"t-kids","props":{"source":"children","of":"entry","as":"doc","tag":"nav"},"label":"Pages in this section","style":{"base":{"display":"grid","gridTemplateColumns":"2","gap":"xs","marginTop":"xl"},"max-md":{"gridTemplateColumns":"1fr"}},"attrs":{"aria-label":"In this section"}}
:::::::: link {"id":"t-kid","style":{"base":{"display":"block","padding":"md md md","backgroundColor":"background-muted","borderRadius":"lg","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}},"bind":{"url":"doc.url"}}
::::::::: paragraph {"id":"t-kid-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}},"bind":{"text":"doc.title"}}
:::::::::

::::::::: paragraph {"id":"t-kid-d","props":{"tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}},"bind":{"text":"doc.description","visible":"doc.description"}}
:::::::::
::::::::
:::::::

::::::: pattern {"id":"t-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: pattern {"id":"t-toc","props":{"ref":"docs-toc"}}
:::::
::::

:::: pattern {"id":"t-footer","props":{"ref":"docs-footer"}}
::::
:::
