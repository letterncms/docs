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

::: box {"id":"df","props":{"tag":"footer"},"label":"Page foot","class":"mt-14"}
:::: box {"id":"df-nav","props":{"tag":"nav"},"class":"grid gap-2 sm:grid-cols-[1fr_1fr]","attrs":{"aria-label":"Previous and next"}}
::::: link {"id":"df-prev","class":"block rounded-lg bg-panel p-[0.875rem_1rem] transition-[color,background-color,border-color] duration-150 ease-[ease] hover:bg-panel-hover","bind":{"url":"entry.prev.url","visible":"entry.prev"}}
:::::: paragraph {"id":"df-prev-l","props":{"text":"Previous","tag":"span"},"class":"block text-sm leading-[1.25rem] text-muted"}
::::::

:::::: paragraph {"id":"df-prev-t","props":{"tag":"span"},"class":"block text-base leading-[1.5] font-heading text-ink","bind":{"text":"entry.prev.title"}}
::::::
:::::

::::: link {"id":"df-next","class":"block rounded-lg bg-panel p-[0.875rem_1rem] text-right transition-[color,background-color,border-color] duration-150 ease-[ease] hover:bg-panel-hover sm:col-[2_/_3]","bind":{"url":"entry.next.url","visible":"entry.next"}}
:::::: paragraph {"id":"df-next-l","props":{"text":"Next","tag":"span"},"class":"block text-sm leading-[1.25rem] text-muted"}
::::::

:::::: paragraph {"id":"df-next-t","props":{"tag":"span"},"class":"block text-base leading-[1.5] font-heading text-ink","bind":{"text":"entry.next.title"}}
::::::
:::::
::::

:::: paragraph {"id":"df-updated","class":"mt-4 text-sm leading-[1.25rem] text-muted","bind":{"text":"Last updated {entry.updated|date:F j, Y}","visible":"entry.updated"}}
::::
:::
