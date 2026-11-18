---
id: 01m6a3docssearch0000000000
title: 'Search results'
status: published
published_at: '2026-11-18T12:00:00+00:00'
position: 7
description: 'A search field and what it found.'
collections:
  - docs
created_at: '2026-11-18T12:00:00+00:00'
updated_at: '2026-11-18T12:00:00+00:00'
---

::: box {"id":"s-root","label":"Docs","class":"flex min-h-dvh flex-col"}
:::: component {"id":"s-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"s-shell","label":"Columns","class":"mx-auto w-[calc(100%-2*var(--spacing-gutter))] max-w-[81.25rem] grow lg:grid lg:grid-cols-[14rem_minmax(0,1fr)] lg:gap-x-[clamp(2rem,4vw,4.5rem)]"}
::::: component {"id":"s-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"s-main","props":{"tag":"main"},"anchor":"main","class":"max-w-[46rem] min-w-0 pt-[clamp(2rem,4vw,3.5rem)] pb-[clamp(4rem,7vw,6rem)]"}
:::::: heading {"id":"s-title","props":{"level":"1","text":"Search"},"bind":{"text":"entry.title"},"class":"text-5xl leading-display font-heading tracking-display text-ink"}
::::::

:::::: search-field {"id":"s-field","props":{"label":"Search the docs","placeholder":"Search the docs","button_label":"Search the docs","button_style":"ghost","icon_only":true,"size":"lg","results_page":"/search"},"class":"docs-search docs-search--big mt-7 max-w-lg"}
::::::

:::::: search-results {"id":"s-results","props":{"heading_level":"2","per_page":20,"show_filters":false,"no_query":"Type what you are looking for.","none":"Nothing found for “{query}”. Try other words.","no_script":"Search needs JavaScript. Browse the sections in the menu instead.","more_style":"secondary"},"class":"docs-results mt-8"}
::::::
:::::
::::

:::: component {"id":"s-footer","props":{"ref":"docs-footer"}}
::::
:::
