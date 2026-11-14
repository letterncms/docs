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

::: box {"id":"dp","props":{"tag":"header"},"label":"Page head","class":"mb-10"}
:::: link {"id":"dp-section","class":"mb-2 inline-block text-sm leading-[1.25rem] text-muted transition-[color,background-color,border-color] duration-150 ease-[ease] hover:text-ink lg:hidden","bind":{"label":"entry.parent.title","url":"entry.parent.url","visible":"entry.parent"}}
::::

:::: heading {"id":"dp-title","props":{"level":"1"},"bind":{"text":"entry.title"}}
::::

:::: paragraph {"id":"dp-desc","class":"mt-3 text-lg leading-[1.45] tracking-normal text-pretty text-muted","bind":{"text":"entry.description","visible":"entry.description"}}
::::

:::: box {"id":"dp-meta","class":"mt-4 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm leading-[1.25rem] text-muted"}
::::: paragraph {"id":"dp-time","props":{"tag":"span"},"bind":{"text":"{readingTime.minutes} min read","visible":"readingTime.minutes"}}
:::::

::::: link {"id":"dp-md","props":{"label":"View as Markdown"},"class":"text-muted transition-[color,background-color,border-color] duration-150 ease-[ease] hover:text-ink","bind":{"url":"page.markdown"}}
:::::
::::
:::
