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

::: box {"id":"ds","props":{"tag":"nav"},"label":"Sidebar","style":{"base":{"position":"sticky","top":"3.5rem","height":"calc(100dvh - 3.5rem)","overflowY":"auto","overscrollBehavior":"contain","scrollbarWidth":"none","paddingTop":"2rem","paddingBottom":"3rem","paddingInline":"0.625rem","marginInline":"-0.625rem"},"tablet":{"display":"none"}},"attrs":{"aria-label":"Documentation"},"anchor":"sidebar"}
:::: repeat {"id":"ds-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"label":"Sections"}
::::: box {"id":"ds-sec","style":{"base":{"marginBottom":"1.75rem"}},"bind":{"visible":"item.children"}}
:::::: link {"id":"ds-sec-t","style":{"base":{"display":"block","marginBottom":"0.375rem","fontSize":"token:text.xs","lineHeight":"1.25rem","fontWeight":500,"letterSpacing":"0.01em","color":"token:color.muted","transition":"color 150ms ease"},"hover":{"color":"token:color.ink"},"current":{"color":"token:color.ink"}},"bind":{"label":"item.title","url":"item.url"}}
::::::

:::::: repeat {"id":"ds-pages","props":{"source":"children","of":"item","as":"doc","tag":"ul"},"style":{"base":{"display":"grid","gap":"1px"}}}
::::::: box {"id":"ds-li","props":{"tag":"li"}}
:::::::: link {"id":"ds-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","paddingInline":"0.625rem","marginInline":"-0.625rem","borderRadius":"token:radius.md","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.foreground","transition":"color 150ms ease, background-color 150ms ease"},"hover":{"color":"token:color.ink","backgroundColor":"token:color.ink/4"},"current":{"color":"token:color.ink","fontWeight":500,"backgroundColor":"token:color.ink/6"}},"bind":{"label":"doc.title","url":"doc.url"}}
::::::::
:::::::
::::::
:::::
::::
:::
