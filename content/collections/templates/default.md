---
id: 01m5x8wt57sd6qwb4pqmg9p9m9
title: 'Default'
status: published
published_at: '2026-10-26T23:31:55+00:00'
position: 1
description: 'Anything without its own template.'
created_at: '2026-10-26T23:31:55+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"d-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"d-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"d-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)] xl:grid-cols-[14rem_minmax(0,1fr)_11.5rem]"}
::::: component {"id":"d-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"d-main","props":{"tag":"main"},"label":"Main","class":"min-w-0 pt-6 pb-20 lg:pt-10","anchor":"main"}
:::::: box {"id":"d-article","props":{"tag":"article"},"label":"Article","class":"mx-auto max-w-(--container-prose)"}
::::::: component {"id":"d-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"d-otp","props":{"tag":"details"},"class":"docs-otp mb-8 rounded-lg bg-panel px-4 xl:hidden"}
:::::::: box {"id":"d-otp-s","props":{"tag":"summary"},"class":"docs-sec__s flex min-h-11 cursor-pointer items-center justify-between text-sm font-medium text-ink"}
::::::::: paragraph {"id":"d-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"d-otp-c","props":{"icon":"caret-down-bold"},"class":"docs-sec__c size-3 text-muted transition-[rotate] duration-200 ease-[ease]"}
:::::::::
::::::::

:::::::: repeat {"id":"d-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"class":"grid pb-3","attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"d-otp-link","class":"block py-[0.3125rem] text-sm leading-[1.25rem] text-muted hover:text-ink data-sub:pl-3","bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"d-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"d-outlet","props":{}}
::::::::
:::::::

::::::: component {"id":"d-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: component {"id":"d-toc","props":{"ref":"docs-toc"}}
:::::
::::

:::: component {"id":"d-footer","props":{"ref":"docs-footer"}}
::::
:::
