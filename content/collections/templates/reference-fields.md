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

::: box {"id":"rf-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: pattern {"id":"rf-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rf-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"},"xl":{"gridTemplateColumns":"14rem minmax(0, 1fr) 11.5rem"}}}
::::: pattern {"id":"rf-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rf-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"1.5rem","paddingBottom":"5rem"},"lg":{"paddingTop":"2.5rem"}},"anchor":"main"}
:::::: box {"id":"rf-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"token:container.prose","marginInline":"auto"}}}
::::::: pattern {"id":"rf-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rf-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"2rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","paddingInline":"1rem"},"xl":{"display":"none"}},"class":"docs-otp"}
:::::::: box {"id":"rf-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","minHeight":"2.75rem","fontSize":"token:text.sm","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"rf-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rf-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: repeat {"id":"rf-otp-list","props":{"source":"cms-field-types","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"0.75rem"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rf-otp-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"}},"bind":{"label":"item.name","url":"#{item.id}"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"rf-body","label":"Body","class":"cms-prose"}
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

::::::: pattern {"id":"rf-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rf-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rf-toc-in","style":{"base":{"position":"sticky","top":"3.5rem","maxHeight":"calc(100dvh - 3.5rem)","overflowY":"auto","scrollbarWidth":"thin","paddingTop":"2.8125rem","paddingBottom":"2.5rem"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rf-toc-list","props":{"source":"cms-field-types","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"content":"\"On this page\"","display":"block","marginBottom":"0.375rem","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink"}}}
:::::::: link {"id":"rf-toc-link","style":{"base":{"display":"block","paddingBlock":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"},"is-current":{"color":"token:color.ink"}},"bind":{"label":"item.label","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: pattern {"id":"rf-footer","props":{"ref":"docs-footer"}}
::::
:::
