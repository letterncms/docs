---
id: 01m5x8xh1tv57vy75mxh46stbs
title: 'Reference: abilities (live)'
status: published
published_at: '2026-10-26T23:32:19+00:00'
position: 2
description: 'Every ability on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:19+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"ra-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"ra-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"ra-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)] xl:grid-cols-[14rem_minmax(0,1fr)_11.5rem]"}
::::: component {"id":"ra-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"ra-main","props":{"tag":"main"},"label":"Main","class":"min-w-0 pt-6 pb-20 lg:pt-10","anchor":"main"}
:::::: box {"id":"ra-article","props":{"tag":"article"},"label":"Article","class":"mx-auto max-w-(--container-prose)"}
::::::: component {"id":"ra-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"ra-otp","props":{"tag":"details"},"class":"docs-otp mb-8 rounded-lg bg-panel px-4 xl:hidden"}
:::::::: box {"id":"ra-otp-s","props":{"tag":"summary"},"class":"docs-sec__s flex min-h-11 cursor-pointer items-center justify-between text-sm font-medium text-ink"}
::::::::: paragraph {"id":"ra-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"ra-otp-c","props":{"icon":"caret-down-bold"},"class":"docs-sec__c size-3 text-muted transition-[rotate] duration-200 ease-[ease]"}
:::::::::
::::::::

:::::::: repeat {"id":"ra-otp-list","props":{"source":"cms-ability-groups","tag":"nav"},"class":"grid pb-3","attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"ra-otp-link","class":"block py-[0.3125rem] text-sm leading-[1.25rem] text-muted hover:text-ink data-sub:pl-3","bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"ra-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"ra-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"ra-groups","props":{"source":"cms-ability-groups","tag":"div","as":"group"},"label":"Namespaces"}
::::::::: heading {"id":"ra-h","props":{"level":"2"},"bind":{"text":"group.name","anchor":"group.id"}}
:::::::::

::::::::: repeat {"id":"ra-list","props":{"source":"list","path":"group.abilities","as":"ability","tag":"div"}}
:::::::::: box {"id":"ra-item","props":{"tag":"section"},"class":"border-t border-line py-5 first:border-t-0","bind":{"attr:id":"ability.id"}}
::::::::::: box {"id":"ra-row","class":"flex flex-wrap items-center gap-2"}
:::::::::::: paragraph {"id":"ra-name","props":{"tag":"span"},"class":"font-mono text-[0.875rem] font-medium text-ink","bind":{"text":"ability.name"}}
::::::::::::

:::::::::::: repeat {"id":"ra-pills","props":{"source":"list","path":"ability.pills","as":"pill","tag":"div"},"class":"flex flex-wrap gap-1.5"}
::::::::::::: paragraph {"id":"ra-pill","props":{"tag":"span"},"class":"inline-flex h-5 items-center rounded-sm bg-panel px-[0.45rem] text-xs whitespace-nowrap text-muted","bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"ra-desc","class":"mt-2","bind":{"text":"ability.description"}}
:::::::::::

::::::::::: table {"id":"ra-table","props":{"header":true},"class":"mt-3","bind":{"rows":"ability.table","visible":"ability.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: component {"id":"ra-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"ra-toc","props":{"tag":"aside"},"label":"On this page","class":"hidden xl:block","attrs":{"aria-label":"On this page"}}
:::::: box {"id":"ra-toc-in","class":"sticky top-14 max-h-[calc(100dvh-3.5rem)] scrollbar-thin overflow-y-auto pt-[2.8125rem] pb-10","logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"ra-toc-list","props":{"source":"cms-ability-groups","tag":"nav"},"class":"flex flex-col before:mb-1.5 before:block before:text-sm before:leading-[1.25rem] before:font-medium before:text-ink before:content-['On_this_page']"}
:::::::: link {"id":"ra-toc-link","class":"block py-1 text-sm leading-[1.25rem] text-muted transition-[color,background-color,border-color] duration-150 ease-[ease] hover:text-ink data-current:text-ink data-sub:pl-3","bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"ra-footer","props":{"ref":"docs-footer"}}
::::
:::
