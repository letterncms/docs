---
id: 01m5x8wnw0mgy2vjzwfkwr6s3n
title: 'Docs page foot'
status: published
published_at: '2026-10-26T23:31:51+00:00'
position: 4
synced: true
category: Docs
description: 'Previous and next page, and when this one last changed.'
created_at: '2026-10-26T23:31:51+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"df","props":{"tag":"footer"},"label":"Page foot","style":{"base":{"marginTop":"2xl"}}}
:::: box {"id":"df-nav","props":{"tag":"nav"},"style":{"base":{"display":"grid","gap":"xs"},"sm":{"gridTemplateColumns":"1fr 1fr"}},"attrs":{"aria-label":"Previous and next"}}
::::: link {"id":"df-prev","style":{"base":{"display":"block","padding":"sm md","backgroundColor":"background-muted","borderRadius":"md","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}},"bind":{"url":"entry.prev.url","visible":"entry.prev"}}
:::::: paragraph {"id":"df-prev-l","props":{"text":"Previous","tag":"span"},"style":{"base":{"display":"block","fontSize":"sm","color":"foreground-muted"}}}
::::::

:::::: paragraph {"id":"df-prev-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"regular","color":"foreground"}},"bind":{"text":"entry.prev.title"}}
::::::
:::::

::::: link {"id":"df-next","style":{"base":{"display":"block","padding":"sm md","backgroundColor":"background-muted","borderRadius":"md","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out","textAlign":"end"},"hover":{"backgroundColor":"background-emphasis"},"sm":{"gridColumn":"2 / 3"}},"bind":{"url":"entry.next.url","visible":"entry.next"}}
:::::: paragraph {"id":"df-next-l","props":{"text":"Next","tag":"span"},"style":{"base":{"display":"block","fontSize":"sm","color":"foreground-muted"}}}
::::::

:::::: paragraph {"id":"df-next-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"regular","color":"foreground"}},"bind":{"text":"entry.next.title"}}
::::::
:::::
::::

:::: paragraph {"id":"df-updated","style":{"base":{"marginTop":"md","fontSize":"sm","color":"foreground-muted"}},"bind":{"text":"Last updated {entry.updated|date:F j, Y}","visible":"entry.updated"}}
::::
:::
