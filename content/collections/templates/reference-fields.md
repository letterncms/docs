---
id: 01m5x8xn1cnc7xaefs2ms8bqmx
title: 'Reference: field types (live)'
status: published
published_at: '2026-10-26T23:32:23+00:00'
position: 4
description: 'Every field type on the running installation, read live.'
collections:
  - docs
created_at: '2026-10-26T23:32:23+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"rf-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"rf-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rf-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)] xl:grid-cols-[14rem_minmax(0,1fr)_11.5rem]"}
::::: component {"id":"rf-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rf-main","props":{"tag":"main"},"label":"Main","class":"min-w-0 pt-6 pb-20 lg:pt-10","anchor":"main"}
:::::: box {"id":"rf-article","props":{"tag":"article"},"label":"Article","class":"mx-auto max-w-(--container-prose)"}
::::::: component {"id":"rf-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rf-otp","props":{"tag":"details"},"class":"docs-otp mb-8 rounded-lg bg-panel px-4 xl:hidden"}
:::::::: box {"id":"rf-otp-s","props":{"tag":"summary"},"class":"docs-sec__s flex min-h-11 cursor-pointer items-center justify-between text-sm font-medium text-ink"}
::::::::: paragraph {"id":"rf-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rf-otp-c","props":{"icon":"caret-down-bold"},"class":"docs-sec__c size-3 text-muted transition-[rotate] duration-200 ease-[ease]"}
:::::::::
::::::::

:::::::: repeat {"id":"rf-otp-list","props":{"source":"cms-field-types","tag":"nav"},"class":"grid pb-3","attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rf-otp-link","class":"block py-[0.3125rem] text-sm leading-[1.25rem] text-muted hover:text-ink data-sub:pl-3","bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"rf-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"rf-outlet","props":{"permalinks":true}}
::::::::

:::::::: repeat {"id":"rf-types","props":{"source":"cms-field-types","tag":"div","as":"type"},"label":"Field types"}
::::::::: heading {"id":"rf-h","props":{"level":"2"},"bind":{"text":"{type.label} · {type.key}","anchor":"type.id"}}
:::::::::

::::::::: paragraph {"id":"rf-desc","bind":{"text":"type.description","visible":"type.description"}}
:::::::::

::::::::: table {"id":"rf-table","props":{"header":true},"bind":{"rows":"type.table","visible":"type.table"}}
:::::::::
::::::::
:::::::

::::::: component {"id":"rf-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rf-toc","props":{"tag":"aside"},"label":"On this page","class":"hidden xl:block","attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rf-toc-in","class":"sticky top-14 max-h-[calc(100dvh-3.5rem)] scrollbar-thin overflow-y-auto pt-[2.8125rem] pb-10","logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rf-toc-list","props":{"source":"cms-field-types","tag":"nav"},"class":"flex flex-col before:mb-1.5 before:block before:text-sm before:leading-[1.25rem] before:font-medium before:text-ink before:content-['On_this_page']"}
:::::::: link {"id":"rf-toc-link","class":"block py-1 text-sm leading-[1.25rem] text-muted transition-[color,background-color,border-color] duration-150 ease-[ease] hover:text-ink data-current:text-ink data-sub:pl-3","bind":{"label":"item.label","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"rf-footer","props":{"ref":"docs-footer"}}
::::
:::
