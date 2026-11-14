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

::: box {"id":"ds","props":{"tag":"nav"},"label":"Sidebar","class":"sticky top-14 -mx-2.5 h-[calc(100dvh-3.5rem)] scrollbar-none overflow-y-auto overscroll-contain px-2.5 pt-8 pb-12 max-lg:hidden","attrs":{"aria-label":"Documentation"},"anchor":"sidebar"}
:::: repeat {"id":"ds-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"label":"Sections"}
::::: box {"id":"ds-sec","class":"mb-7","bind":{"visible":"item.children"}}
:::::: link {"id":"ds-sec-t","class":"mb-1.5 block text-xs leading-[1.25rem] font-medium tracking-[0.01em] text-muted transition-colors duration-150 ease-[ease] hover:text-ink current:text-ink","bind":{"label":"item.title","url":"item.url"}}
::::::

:::::: repeat {"id":"ds-pages","props":{"source":"children","of":"item","as":"doc","tag":"ul"},"class":"grid gap-px"}
::::::: box {"id":"ds-li","props":{"tag":"li"}}
:::::::: link {"id":"ds-link","class":"-mx-2.5 block rounded-md px-2.5 py-[0.3125rem] text-sm leading-[1.25rem] text-foreground transition-[color,background-color] duration-150 ease-[ease] hover:bg-ink/4 hover:text-ink current:bg-ink/6 current:font-medium current:text-ink","bind":{"label":"doc.title","url":"doc.url"}}
::::::::
:::::::
::::::
:::::
::::
:::
