---
id: 01m5x8wfjrmba9413w5x1y0krz
title: 'Docs sidebar'
status: published
published_at: '2026-10-26T23:31:44+00:00'
position: 1
synced: true
category: Docs
description: 'Every section and its pages, in one list.'
created_at: '2026-10-26T23:31:44+00:00'
updated_at: '2026-11-02T12:00:00+00:00'
---

::: box {"id":"ds","props":{"tag":"nav"},"label":"Sidebar","style":{"base":{"position":"sticky","top":"2xl","height":"vh-100","overflowY":"auto","overscrollBehavior":"contain","paddingTop":"xl","paddingBottom":"2xl","paddingInline":"xs","marginInline":"-xs"},"max-lg":{"display":"none"}},"attrs":{"aria-label":"Documentation"},"anchor":"sidebar"}
:::: repeat {"id":"ds-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"label":"Sections"}
::::: box {"id":"ds-sec","style":{"base":{"marginBottom":"lg"}},"bind":{"visible":"item.children"}}
:::::: link {"id":"ds-sec-t","style":{"base":{"display":"block","marginBottom":"2xs","fontSize":"xs","fontWeight":"medium","letterSpacing":"normal","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"current":{"color":"foreground"}},"bind":{"label":"item.title","url":"item.url"}}
::::::

:::::: repeat {"id":"ds-pages","props":{"source":"children","of":"item","as":"doc","tag":"ul"},"style":{"base":{"display":"grid","gap":"3xs"}}}
::::::: box {"id":"ds-li","props":{"tag":"li"}}
:::::::: link {"id":"ds-link","style":{"base":{"display":"block","paddingBlock":"2xs","paddingInline":"xs","marginInline":"-xs","borderRadius":"md","fontSize":"sm","color":"foreground","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground","backgroundColor":"foreground/5"},"current":{"color":"foreground","fontWeight":"medium","backgroundColor":"foreground/5"}},"bind":{"label":"doc.title","url":"doc.url"}}
::::::::
:::::::
::::::
:::::
::::
:::
