---
id: 01m6a3docshome000000000000
title: 'Docs home'
status: published
published_at: '2026-10-30T12:00:00+00:00'
position: 6
description: 'Search, where to start, and every section.'
collections:
  - docs
created_at: '2026-10-30T12:00:00+00:00'
updated_at: '2026-11-02T12:00:00+00:00'
---

::: box {"id":"h-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"h-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"h-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)]"}
::::: component {"id":"h-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"h-main","props":{"tag":"main"},"anchor":"main","class":"max-w-4xl min-w-0 pt-[clamp(2rem,4vw,3.5rem)] pb-[clamp(4rem,7vw,6rem)]"}
:::::: box {"id":"h-hero"}
::::::: heading {"id":"h-title","props":{"level":"1","text":"Lettern documentation"},"class":"text-5xl leading-display font-heading tracking-display text-ink"}
:::::::

::::::: box {"id":"h-body","class":"cms-prose docs-lead mt-3.5 max-w-[38rem]"}
:::::::: outlet {"id":"h-outlet"}
::::::::
:::::::

::::::: search {"id":"h-search","props":{"label":"Search the docs","placeholder":"Search the docs","empty":"Nothing found. Try other words.","shortcut":true},"class":"docs-search docs-search--big mt-7 flex h-12 w-full max-w-lg"}
:::::::
::::::

:::::: box {"id":"h-start","props":{"tag":"section"},"attrs":{"aria-labelledby":"start-here"},"class":"mt-[clamp(2.5rem,4vw,3.5rem)]"}
::::::: heading {"id":"h-start-h","props":{"level":"2","text":"Start here"},"anchor":"start-here","class":"mb-4 text-lg leading-[1.4] font-heading text-ink"}
:::::::

::::::: box {"id":"h-cards","class":"grid grid-cols-2 gap-3 max-md:grid-cols-1"}
:::::::: link {"id":"h-c1","props":{"url":"/getting-started/installation"},"class":"flex flex-col overflow-hidden rounded-xl bg-panel transition-[background-color] duration-150 ease-[ease] hover:bg-panel-hover"}
::::::::: box {"id":"h-c1-p","class":"relative h-50 overflow-hidden pt-6 pl-6 max-md:h-40"}
:::::::::: image {"id":"h-c1-i","props":{"image":"/media/screens/dashboard.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"class":"block w-[200%] max-w-none overflow-hidden rounded-lg bg-[#ffffff] shadow-[0_0_0_1px_rgb(43_41_38_/_0.08),0_8px_24px_rgb(43_41_38_/_0.06)]"}
::::::::::
:::::::::

::::::::: box {"id":"h-c1-x","class":"p-[1rem_1.25rem_1.25rem]"}
:::::::::: paragraph {"id":"h-c1-t","props":{"text":"Install Lettern","tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink"}
::::::::::

:::::::::: paragraph {"id":"h-c1-d","props":{"text":"Upload a zip to any PHP host, or use Composer. A few minutes, start to finish.","tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted"}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c2","props":{"url":"/getting-started/quick-start"},"class":"flex flex-col overflow-hidden rounded-xl bg-panel transition-[background-color] duration-150 ease-[ease] hover:bg-panel-hover"}
::::::::: box {"id":"h-c2-p","class":"relative h-50 overflow-hidden pt-6 pl-6 max-md:h-40"}
:::::::::: image {"id":"h-c2-i","props":{"image":"/media/screens/editor.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"class":"block w-[200%] max-w-none overflow-hidden rounded-lg bg-[#ffffff] shadow-[0_0_0_1px_rgb(43_41_38_/_0.08),0_8px_24px_rgb(43_41_38_/_0.06)]"}
::::::::::
:::::::::

::::::::: box {"id":"h-c2-x","class":"p-[1rem_1.25rem_1.25rem]"}
:::::::::: paragraph {"id":"h-c2-t","props":{"text":"Build your first page","tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink"}
::::::::::

:::::::::: paragraph {"id":"h-c2-d","props":{"text":"Write, add blocks and publish, right on the page itself.","tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted"}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c3","props":{"url":"/design/site-design"},"class":"flex flex-col overflow-hidden rounded-xl bg-panel transition-[background-color] duration-150 ease-[ease] hover:bg-panel-hover"}
::::::::: box {"id":"h-c3-p","class":"relative h-50 overflow-hidden pt-6 pl-6 max-md:h-40"}
:::::::::: image {"id":"h-c3-i","props":{"image":"/media/screens/design.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"class":"block w-[200%] max-w-none overflow-hidden rounded-lg bg-[#ffffff] shadow-[0_0_0_1px_rgb(43_41_38_/_0.08),0_8px_24px_rgb(43_41_38_/_0.06)]"}
::::::::::
:::::::::

::::::::: box {"id":"h-c3-x","class":"p-[1rem_1.25rem_1.25rem]"}
:::::::::: paragraph {"id":"h-c3-t","props":{"text":"Make it yours","tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink"}
::::::::::

:::::::::: paragraph {"id":"h-c3-d","props":{"text":"Pick colors, fonts and spacing once. Every page follows.","tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted"}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c4","props":{"url":"/agents/assistant"},"class":"flex flex-col overflow-hidden rounded-xl bg-panel transition-[background-color] duration-150 ease-[ease] hover:bg-panel-hover"}
::::::::: box {"id":"h-c4-p","class":"relative h-50 overflow-hidden pt-6 pl-6 max-md:h-40"}
:::::::::: box {"id":"h-c4-chat","attrs":{"aria-hidden":"true"},"class":"flex flex-col gap-2.5 pr-6"}
::::::::::: paragraph {"id":"h-c4-q","props":{"text":"Add a pricing section with three plans to the home page","tag":"span"},"class":"max-w-68 self-end rounded-2xl rounded-br-[0.375rem] bg-yellow p-[0.625rem_0.875rem] text-sm leading-[1.35] text-on-yellow shadow-[0_0_0_1px_rgb(43_41_38_/_0.06)]"}
:::::::::::

::::::::::: box {"id":"h-c4-s","class":"flex items-center gap-2 text-xs leading-[1rem] text-muted"}
:::::::::::: icon {"id":"h-c4-s-i","props":{"icon":"check-circle"},"class":"size-3.5 text-ink"}
::::::::::::

:::::::::::: paragraph {"id":"h-c4-s-t","props":{"text":"entries/update · Home","tag":"span"},"class":"font-mono"}
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"h-c4-a","props":{"text":"Done. Home now has a Pricing section with Starter, Studio and Agency. Publish it?","tag":"span"},"class":"max-w-68 rounded-2xl rounded-bl-[0.375rem] bg-raised p-[0.625rem_0.875rem] text-sm leading-[1.35] text-ink shadow-[0_0_0_1px_rgb(43_41_38_/_0.06)]"}
:::::::::::
::::::::::
:::::::::

::::::::: box {"id":"h-c4-x","class":"p-[1rem_1.25rem_1.25rem]"}
:::::::::: paragraph {"id":"h-c4-t","props":{"text":"Work with AI","tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink"}
::::::::::

:::::::::: paragraph {"id":"h-c4-d","props":{"text":"Ask the assistant, or connect Claude, ChatGPT or Cursor to your site.","tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted"}
::::::::::
:::::::::
::::::::
:::::::
::::::

:::::: box {"id":"h-topics","props":{"tag":"section"},"attrs":{"aria-labelledby":"all-topics"},"class":"mt-[clamp(3rem,5vw,4.5rem)]"}
::::::: heading {"id":"h-topics-h","props":{"level":"2","text":"Browse by topic"},"anchor":"all-topics","class":"mb-4 text-lg leading-[1.4] font-heading text-ink"}
:::::::

::::::: repeat {"id":"h-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"class":"grid grid-cols-2 gap-x-10 gap-y-0 max-md:grid-cols-1"}
:::::::: link {"id":"h-sec","class":"docs-topic block border-t border-line py-4 transition-colors duration-150 ease-[ease] hover:text-ink","bind":{"url":"item.url","visible":"item.children"}}
::::::::: paragraph {"id":"h-sec-t","props":{"tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink","bind":{"text":"item.title"}}
:::::::::

::::::::: paragraph {"id":"h-sec-d","props":{"tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted","bind":{"text":"item.description","visible":"item.description"}}
:::::::::
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"h-footer","props":{"ref":"docs-footer"}}
::::
:::
