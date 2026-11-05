---
id: 01m5x8wkbvrswtkjf9d5m2zkdb
title: 'Docs page head'
status: published
published_at: '2026-10-26T23:31:48+00:00'
position: 3
synced: true
category: Docs
description: 'Section, title, description, reading time and the Markdown twin.'
created_at: '2026-10-26T23:31:48+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"dp","props":{"tag":"header"},"label":"Page head","style":{"base":{"marginBottom":"xl"}}}
:::: link {"id":"dp-section","style":{"base":{"display":"inline-block","marginBottom":"xs","fontSize":"sm","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"lg":{"display":"none"}},"bind":{"label":"entry.parent.title","url":"entry.parent.url","visible":"entry.parent"}}
::::

:::: heading {"id":"dp-title","props":{"level":"1"},"bind":{"text":"entry.title"}}
::::

:::: paragraph {"id":"dp-desc","style":{"base":{"marginTop":"sm","fontSize":"base","lineHeight":"normal","letterSpacing":"normal","color":"foreground-muted","textWrap":"pretty"}},"bind":{"text":"entry.description","visible":"entry.description"}}
::::

:::: box {"id":"dp-meta","style":{"base":{"marginTop":"md","display":"flex","flexWrap":"wrap","alignItems":"center","gap":"2xs md","fontSize":"sm","color":"foreground-muted"}}}
::::: paragraph {"id":"dp-time","props":{"tag":"span"},"bind":{"text":"{readingTime.minutes} min read","visible":"readingTime.minutes"}}
:::::

::::: link {"id":"dp-md","props":{"label":"View as Markdown"},"style":{"base":{"color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"}},"bind":{"url":"page.markdown"}}
:::::
::::
:::
