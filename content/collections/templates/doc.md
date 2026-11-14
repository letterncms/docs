---
id: 01m5x8wr4cqfwcaq7aecq8traj
title: 'Documentation page'
status: published
published_at: '2026-10-26T23:31:53+00:00'
position: 0
description: 'The page with its head and prev/next, On this page, and a card for each page of a section.'
collections:
  - docs
created_at: '2026-10-26T23:31:53+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"t-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"t-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"t-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)] xl:grid-cols-[14rem_minmax(0,1fr)_11.5rem]"}
::::: component {"id":"t-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"t-main","props":{"tag":"main"},"label":"Main","class":"min-w-0 pt-6 pb-20 lg:pt-10","anchor":"main"}
:::::: box {"id":"t-article","props":{"tag":"article"},"label":"Article","class":"mx-auto max-w-[46rem]"}
::::::: component {"id":"t-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"t-otp","props":{"tag":"details"},"class":"docs-otp mb-8 rounded-lg bg-panel px-4 xl:hidden"}
:::::::: box {"id":"t-otp-s","props":{"tag":"summary"},"class":"docs-sec__s flex min-h-11 cursor-pointer items-center justify-between text-sm font-medium text-ink"}
::::::::: paragraph {"id":"t-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"t-otp-c","props":{"icon":"caret-down-bold"},"class":"docs-sec__c size-3 text-muted transition-[rotate] duration-200 ease-[ease]"}
:::::::::
::::::::

:::::::: repeat {"id":"t-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"class":"grid pb-3","attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"t-otp-link","class":"block py-[0.3125rem] text-sm leading-[1.25rem] text-muted hover:text-ink data-sub:pl-3","bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"t-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"t-outlet","props":{"permalinks":true}}
::::::::
:::::::

::::::: repeat {"id":"t-kids","props":{"source":"children","of":"entry","as":"doc","tag":"nav"},"label":"Pages in this section","class":"mt-8 grid grid-cols-2 gap-2 max-md:grid-cols-1","attrs":{"aria-label":"In this section"}}
:::::::: link {"id":"t-kid","class":"block rounded-xl bg-panel p-[1rem_1.125rem_1.125rem] transition-[background-color] duration-150 ease-[ease] hover:bg-panel-hover","bind":{"url":"doc.url"}}
::::::::: paragraph {"id":"t-kid-t","props":{"tag":"span"},"class":"block text-base leading-[1.5] font-medium text-ink","bind":{"text":"doc.title"}}
:::::::::

::::::::: paragraph {"id":"t-kid-d","props":{"tag":"span"},"class":"mt-1 block text-sm leading-[1.25rem] text-pretty text-muted","bind":{"text":"doc.description","visible":"doc.description"}}
:::::::::
::::::::
:::::::

::::::: component {"id":"t-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: component {"id":"t-toc","props":{"ref":"docs-toc"}}
:::::
::::

:::: component {"id":"t-footer","props":{"ref":"docs-footer"}}
::::
:::
