---
id: 01m5x8wfjrmba9413w5x1y0krz
title: 'Docs sidebar'
status: published
published_at: '2026-10-26T23:31:44+00:00'
position: 1
synced: true
category: Docs
description: 'The pages of the section the reader is in, by group.'
created_at: '2026-10-26T23:31:44+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"ds","props":{"tag":"nav"},"label":"Sidebar","style":{"base":{"position":"sticky","top":"3.5rem","height":"calc(100dvh - 3.5rem)","overflowY":"auto","overscrollBehavior":"contain","scrollbarWidth":"thin","paddingTop":"2.5rem","paddingBottom":"2.5rem","paddingInline":"0.625rem","marginInline":"-0.625rem"},"tablet":{"display":"none"}},"attrs":{"aria-label":"This section"},"anchor":"sidebar"}
:::: link {"id":"ds-root","style":{"base":{"display":"block","paddingBlock":"0.3125rem","paddingInline":"0.625rem","marginInline":"-0.625rem","borderRadius":"token:radius.md","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.ink/6"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}},"bind":{"label":"entry.root.title","url":"entry.root.url"}}
::::

:::: repeat {"id":"ds-groups","props":{"source":"children","of":"root","group_by":"group","as":"group","tag":"div"},"label":"Groups"}
::::: box {"id":"ds-group","style":{"base":{"marginTop":"1.5rem"}}}
:::::: paragraph {"id":"ds-group-l","props":{"tag":"p"},"style":{"base":{"marginBottom":"0.25rem","fontSize":"token:text.xs","lineHeight":"1.25rem","color":"token:color.muted"}},"bind":{"text":"group.label","visible":"group.label"}}
::::::

:::::: repeat {"id":"ds-pages","props":{"source":"list","path":"group.items","as":"doc","tag":"ul"},"style":{"base":{"display":"grid","gap":"1px"}}}
::::::: box {"id":"ds-li","props":{"tag":"li"}}
:::::::: link {"id":"ds-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","paddingInline":"0.625rem","marginInline":"-0.625rem","borderRadius":"token:radius.md","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.foreground","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.ink/6"},"current":{"color":"token:color.ink","fontWeight":500,"backgroundColor":"token:color.ink/6"}},"bind":{"label":"doc.title","url":"doc.url"}}
::::::::
:::::::
::::::
:::::
::::
:::
