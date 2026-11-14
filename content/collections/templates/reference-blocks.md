---
id: 01m5x8xk0t9xnmkby6znsjw1e6
title: 'Reference: blocks (live)'
status: published
published_at: '2026-10-26T23:32:21+00:00'
position: 3
description: 'Every block on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:21+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"rb-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"rb-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rb-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)] xl:grid-cols-[14rem_minmax(0,1fr)_11.5rem]"}
::::: component {"id":"rb-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rb-main","props":{"tag":"main"},"label":"Main","class":"min-w-0 pt-6 pb-20 lg:pt-10","anchor":"main"}
:::::: box {"id":"rb-article","props":{"tag":"article"},"label":"Article","class":"mx-auto max-w-(--container-prose)"}
::::::: component {"id":"rb-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rb-otp","props":{"tag":"details"},"class":"docs-otp mb-8 rounded-lg bg-panel px-4 xl:hidden"}
:::::::: box {"id":"rb-otp-s","props":{"tag":"summary"},"class":"docs-sec__s flex min-h-11 cursor-pointer items-center justify-between text-sm font-medium text-ink"}
::::::::: paragraph {"id":"rb-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rb-otp-c","props":{"icon":"caret-down-bold"},"class":"docs-sec__c size-3 text-muted transition-[rotate] duration-200 ease-[ease]"}
:::::::::
::::::::

:::::::: repeat {"id":"rb-otp-list","props":{"source":"cms-block-categories","tag":"nav"},"class":"grid pb-3","attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rb-otp-link","class":"block py-[0.3125rem] text-sm leading-[1.25rem] text-muted hover:text-ink data-sub:pl-3","bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"rb-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"rb-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"rb-groups","props":{"source":"cms-block-categories","tag":"div","as":"group"},"label":"Categories"}
::::::::: heading {"id":"rb-h","props":{"level":"2"},"bind":{"text":"group.name","anchor":"group.id"}}
:::::::::

::::::::: repeat {"id":"rb-list","props":{"source":"list","path":"group.blocks","as":"block","tag":"div"}}
:::::::::: box {"id":"rb-item","props":{"tag":"section"},"class":"border-t border-line py-5 first:border-t-0","bind":{"attr:id":"block.id"}}
::::::::::: box {"id":"rb-row","class":"flex flex-wrap items-center gap-2"}
:::::::::::: paragraph {"id":"rb-name","props":{"tag":"span"},"class":"font-mono text-[0.875rem] font-medium text-ink","bind":{"text":"block.name"}}
::::::::::::

:::::::::::: paragraph {"id":"rb-title","props":{"tag":"span"},"class":"text-sm text-muted","bind":{"text":"block.title"}}
::::::::::::

:::::::::::: repeat {"id":"rb-pills","props":{"source":"list","path":"block.pills","as":"pill","tag":"div"},"class":"flex flex-wrap gap-1.5"}
::::::::::::: paragraph {"id":"rb-pill","props":{"tag":"span"},"class":"inline-flex h-5 items-center rounded-sm bg-panel px-[0.45rem] text-xs whitespace-nowrap text-muted","bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"rb-desc","class":"mt-2","bind":{"text":"block.description","visible":"block.description"}}
:::::::::::

::::::::::: table {"id":"rb-table","props":{"header":true},"class":"mt-3","bind":{"rows":"block.table","visible":"block.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: component {"id":"rb-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rb-toc","props":{"tag":"aside"},"label":"On this page","class":"hidden xl:block","attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rb-toc-in","class":"sticky top-14 max-h-[calc(100dvh-3.5rem)] scrollbar-thin overflow-y-auto pt-[2.8125rem] pb-10","logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rb-toc-list","props":{"source":"cms-block-categories","tag":"nav"},"class":"flex flex-col before:mb-1.5 before:block before:text-sm before:leading-[1.25rem] before:font-medium before:text-ink before:content-['On_this_page']"}
:::::::: link {"id":"rb-toc-link","class":"block py-1 text-sm leading-[1.25rem] text-muted transition-[color,background-color,border-color] duration-150 ease-[ease] hover:text-ink data-current:text-ink data-sub:pl-3","bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"rb-footer","props":{"ref":"docs-footer"}}
::::
:::
