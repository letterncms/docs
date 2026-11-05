---
id: 01m5x8xk0t9xnmkby6znsjw1e6
title: 'Reference: blocks (live)'
status: published
published_at: '2026-10-26T23:32:21+00:00'
position: 3
description: 'Every block on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:21+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"rb-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"rb-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rb-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"},"xl":{"gridTemplateColumns":"6xl 1fr 6xl"}}}
::::: pattern {"id":"rb-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rb-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"lg","paddingBottom":"3xl"},"lg":{"paddingTop":"xl"}},"anchor":"main"}
:::::: box {"id":"rb-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"text","marginInline":"auto"}}}
::::::: pattern {"id":"rb-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rb-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"xl","backgroundColor":"background-muted","borderRadius":"md","paddingInline":"md"},"xl":{"display":"none"}}}
:::::::: box {"id":"rb-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"between","minHeight":"xl","fontSize":"sm","fontWeight":"medium","color":"foreground","cursor":"pointer"}}}
::::::::: paragraph {"id":"rb-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rb-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"sm","height":"sm","color":"foreground-muted","transitionProperty":"transform","transitionDuration":"fast","transitionTimingFunction":"out"},"in-open":{"rotate":"180"}}}
:::::::::
::::::::

:::::::: repeat {"id":"rb-otp-list","props":{"source":"cms-block-categories","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"sm"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rb-otp-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"}},"bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"rb-body","label":"Body","style":{"base":{"flow":"prose"}}}
:::::::: outlet {"id":"rb-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"rb-groups","props":{"source":"cms-block-categories","tag":"div","as":"group"},"label":"Categories"}
::::::::: heading {"id":"rb-h","props":{"level":"2"},"bind":{"text":"group.name","anchor":"group.id"}}
:::::::::

::::::::: repeat {"id":"rb-list","props":{"source":"list","path":"group.blocks","as":"block","tag":"div"}}
:::::::::: box {"id":"rb-item","props":{"tag":"section"},"style":{"base":{"paddingBlock":"md","borderTopWidth":"1","borderStyle":"solid","borderColor":"border"},"first":{"borderTopWidth":"0"}},"bind":{"attr:id":"block.id"}}
::::::::::: box {"id":"rb-row","style":{"base":{"display":"flex","flexWrap":"wrap","alignItems":"center","gap":"xs"}}}
:::::::::::: paragraph {"id":"rb-name","props":{"tag":"span"},"style":{"base":{"fontFamily":"mono","fontSize":"sm","fontWeight":"medium","color":"foreground"}},"bind":{"text":"block.name"}}
::::::::::::

:::::::::::: paragraph {"id":"rb-title","props":{"tag":"span"},"style":{"base":{"fontSize":"sm","color":"foreground-muted"}},"bind":{"text":"block.title"}}
::::::::::::

:::::::::::: repeat {"id":"rb-pills","props":{"source":"list","path":"block.pills","as":"pill","tag":"div"},"style":{"base":{"display":"flex","flexWrap":"wrap","gap":"2xs"}}}
::::::::::::: paragraph {"id":"rb-pill","props":{"tag":"span"},"style":{"base":{"display":"inline-flex","alignItems":"center","height":"md","paddingInline":"xs","backgroundColor":"background-muted","borderRadius":"sm","fontSize":"xs","color":"foreground-muted","whiteSpace":"nowrap"}},"bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"rb-desc","style":{"base":{"marginTop":"xs"}},"bind":{"text":"block.description","visible":"block.description"}}
:::::::::::

::::::::::: table {"id":"rb-table","props":{"header":true},"style":{"base":{"marginTop":"sm"}},"bind":{"rows":"block.table","visible":"block.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: pattern {"id":"rb-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rb-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rb-toc-in","style":{"base":{"position":"sticky","top":"2xl","maxHeight":"vh-100","overflowY":"auto","paddingTop":"xl","paddingBottom":"xl"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rb-toc-list","props":{"source":"cms-block-categories","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"display":"block","marginBottom":"2xs","fontSize":"sm","fontWeight":"medium","color":"foreground"}}}
:::::::: link {"id":"rb-toc-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"},"is-current":{"color":"foreground"}},"bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: pattern {"id":"rb-footer","props":{"ref":"docs-footer"}}
::::
:::
