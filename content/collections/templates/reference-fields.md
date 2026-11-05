---
id: 01m5x8xn1cnc7xaefs2ms8bqmx
title: 'Reference: field types (live)'
status: published
published_at: '2026-10-26T23:32:23+00:00'
position: 4
description: 'Every field type on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:23+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"rf-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"rf-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rf-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"},"xl":{"gridTemplateColumns":"6xl 1fr 6xl"}}}
::::: pattern {"id":"rf-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rf-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"lg","paddingBottom":"3xl"},"lg":{"paddingTop":"xl"}},"anchor":"main"}
:::::: box {"id":"rf-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"text","marginInline":"auto"}}}
::::::: pattern {"id":"rf-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rf-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"xl","backgroundColor":"background-muted","borderRadius":"md","paddingInline":"md"},"xl":{"display":"none"}}}
:::::::: box {"id":"rf-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"between","minHeight":"xl","fontSize":"sm","fontWeight":"medium","color":"foreground","cursor":"pointer"}}}
::::::::: paragraph {"id":"rf-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rf-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"sm","height":"sm","color":"foreground-muted","transitionProperty":"transform","transitionDuration":"fast","transitionTimingFunction":"out"},"in-open":{"rotate":"180"}}}
:::::::::
::::::::

:::::::: repeat {"id":"rf-otp-list","props":{"source":"cms-field-types","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"sm"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rf-otp-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"}},"bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"rf-body","label":"Body","style":{"base":{"flow":"prose"}}}
:::::::: outlet {"id":"rf-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"rf-types","props":{"source":"cms-field-types","tag":"div","as":"type"},"label":"Field types"}
::::::::: heading {"id":"rf-h","props":{"level":"2"},"bind":{"text":"{type.label} · {type.key}","anchor":"type.id"}}
:::::::::

::::::::: paragraph {"id":"rf-desc","bind":{"text":"type.description","visible":"type.description"}}
:::::::::

::::::::: table {"id":"rf-table","props":{"header":true},"bind":{"rows":"type.table","visible":"type.table"}}
:::::::::
::::::::
:::::::

::::::: pattern {"id":"rf-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rf-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rf-toc-in","style":{"base":{"position":"sticky","top":"2xl","maxHeight":"vh-100","overflowY":"auto","paddingTop":"xl","paddingBottom":"xl"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rf-toc-list","props":{"source":"cms-field-types","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"display":"block","marginBottom":"2xs","fontSize":"sm","fontWeight":"medium","color":"foreground"}}}
:::::::: link {"id":"rf-toc-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"},"is-current":{"color":"foreground"}},"bind":{"label":"item.label","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: pattern {"id":"rf-footer","props":{"ref":"docs-footer"}}
::::
:::
