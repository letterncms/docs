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

::: box {"id":"df","props":{"tag":"footer"},"label":"Page foot","style":{"base":{"marginTop":"3.5rem"}}}
:::: box {"id":"df-nav","props":{"tag":"nav"},"style":{"base":{"display":"grid","gap":"0.5rem"},"sm":{"gridTemplateColumns":"1fr 1fr"}},"attrs":{"aria-label":"Previous and next"}}
::::: link {"id":"df-prev","style":{"base":{"display":"block","padding":"0.875rem 1rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}},"bind":{"url":"entry.prev.url","visible":"entry.prev"}}
:::::: paragraph {"id":"df-prev-l","props":{"text":"Previous","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"}}}
::::::

:::::: paragraph {"id":"df-prev-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.heading","color":"token:color.ink"}},"bind":{"text":"entry.prev.title"}}
::::::
:::::

::::: link {"id":"df-next","style":{"base":{"display":"block","padding":"0.875rem 1rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","textAlign":"right"},"hover":{"backgroundColor":"token:color.panel-hover"},"sm":{"gridColumn":"2 / 3"}},"bind":{"url":"entry.next.url","visible":"entry.next"}}
:::::: paragraph {"id":"df-next-l","props":{"text":"Next","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"}}}
::::::

:::::: paragraph {"id":"df-next-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.heading","color":"token:color.ink"}},"bind":{"text":"entry.next.title"}}
::::::
:::::
::::

:::: paragraph {"id":"df-updated","style":{"base":{"marginTop":"1rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"}},"bind":{"text":"Last updated {entry.updated|date:F j, Y}","visible":"entry.updated"}}
::::
:::
