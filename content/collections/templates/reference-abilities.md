---
id: 01m5x8xh1tv57vy75mxh46stbs
title: 'Reference: abilities (live)'
status: published
published_at: '2026-10-26T23:32:19+00:00'
position: 2
description: 'Every ability on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:19+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"ra-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"ra-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"ra-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"},"xl":{"gridTemplateColumns":"6xl 1fr 6xl"}}}
::::: pattern {"id":"ra-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"ra-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"lg","paddingBottom":"3xl"},"lg":{"paddingTop":"xl"}},"anchor":"main"}
:::::: box {"id":"ra-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"text","marginInline":"auto"}}}
::::::: pattern {"id":"ra-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"ra-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"xl","backgroundColor":"background-muted","borderRadius":"md","paddingInline":"md"},"xl":{"display":"none"}}}
:::::::: box {"id":"ra-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"between","minHeight":"xl","fontSize":"sm","fontWeight":"medium","color":"foreground","cursor":"pointer"}}}
::::::::: paragraph {"id":"ra-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"ra-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"sm","height":"sm","color":"foreground-muted","transitionProperty":"transform","transitionDuration":"fast","transitionTimingFunction":"out"},"in-open":{"rotate":"180"}}}
:::::::::
::::::::

:::::::: repeat {"id":"ra-otp-list","props":{"source":"cms-ability-groups","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"sm"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"ra-otp-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"}},"bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"ra-body","label":"Body","style":{"base":{"flow":"prose"}}}
:::::::: outlet {"id":"ra-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"ra-groups","props":{"source":"cms-ability-groups","tag":"div","as":"group"},"label":"Namespaces"}
::::::::: heading {"id":"ra-h","props":{"level":"2"},"bind":{"text":"group.name","anchor":"group.id"}}
:::::::::

::::::::: repeat {"id":"ra-list","props":{"source":"list","path":"group.abilities","as":"ability","tag":"div"}}
:::::::::: box {"id":"ra-item","props":{"tag":"section"},"style":{"base":{"paddingBlock":"md","borderTopWidth":"1","borderStyle":"solid","borderColor":"border"},"first":{"borderTopWidth":"0"}},"bind":{"attr:id":"ability.id"}}
::::::::::: box {"id":"ra-row","style":{"base":{"display":"flex","flexWrap":"wrap","alignItems":"center","gap":"xs"}}}
:::::::::::: paragraph {"id":"ra-name","props":{"tag":"span"},"style":{"base":{"fontFamily":"mono","fontSize":"sm","fontWeight":"medium","color":"foreground"}},"bind":{"text":"ability.name"}}
::::::::::::

:::::::::::: repeat {"id":"ra-pills","props":{"source":"list","path":"ability.pills","as":"pill","tag":"div"},"style":{"base":{"display":"flex","flexWrap":"wrap","gap":"2xs"}}}
::::::::::::: paragraph {"id":"ra-pill","props":{"tag":"span"},"style":{"base":{"display":"inline-flex","alignItems":"center","height":"md","paddingInline":"xs","backgroundColor":"background-muted","borderRadius":"sm","fontSize":"xs","color":"foreground-muted","whiteSpace":"nowrap"}},"bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"ra-desc","style":{"base":{"marginTop":"xs"}},"bind":{"text":"ability.description"}}
:::::::::::

::::::::::: table {"id":"ra-table","props":{"header":true},"style":{"base":{"marginTop":"sm"}},"bind":{"rows":"ability.table","visible":"ability.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: pattern {"id":"ra-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"ra-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"ra-toc-in","style":{"base":{"position":"sticky","top":"2xl","maxHeight":"vh-100","overflowY":"auto","paddingTop":"xl","paddingBottom":"xl"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"ra-toc-list","props":{"source":"cms-ability-groups","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"display":"block","marginBottom":"2xs","fontSize":"sm","fontWeight":"medium","color":"foreground"}}}
:::::::: link {"id":"ra-toc-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"},"is-current":{"color":"foreground"}},"bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: pattern {"id":"ra-footer","props":{"ref":"docs-footer"}}
::::
:::
