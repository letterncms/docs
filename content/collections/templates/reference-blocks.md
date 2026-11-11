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

::: box {"id":"rb-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: component {"id":"rb-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"rb-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"},"xl":{"gridTemplateColumns":"14rem minmax(0, 1fr) 11.5rem"}}}
::::: component {"id":"rb-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"rb-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"1.5rem","paddingBottom":"5rem"},"lg":{"paddingTop":"2.5rem"}},"anchor":"main"}
:::::: box {"id":"rb-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"token:container.prose","marginInline":"auto"}}}
::::::: component {"id":"rb-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"rb-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"2rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","paddingInline":"1rem"},"xl":{"display":"none"}},"class":"docs-otp"}
:::::::: box {"id":"rb-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","minHeight":"2.75rem","fontSize":"token:text.sm","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"rb-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"rb-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: repeat {"id":"rb-otp-list","props":{"source":"cms-block-categories","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"0.75rem"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"rb-otp-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"}},"bind":{"label":"item.name","url":"#{item.id}"}}
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
:::::::::: box {"id":"rb-item","props":{"tag":"section"},"style":{"base":{"paddingBlock":"1.25rem","borderTop":"1px solid token:color.line"},"first":{"borderTop":"0"}},"bind":{"attr:id":"block.id"}}
::::::::::: box {"id":"rb-row","style":{"base":{"display":"flex","flexWrap":"wrap","alignItems":"center","gap":"0.5rem"}}}
:::::::::::: paragraph {"id":"rb-name","props":{"tag":"span"},"style":{"base":{"fontFamily":"token:font.mono","fontSize":"0.875rem","fontWeight":500,"color":"token:color.ink"}},"bind":{"text":"block.name"}}
::::::::::::

:::::::::::: paragraph {"id":"rb-title","props":{"tag":"span"},"style":{"base":{"fontSize":"token:text.sm","color":"token:color.muted"}},"bind":{"text":"block.title"}}
::::::::::::

:::::::::::: repeat {"id":"rb-pills","props":{"source":"list","path":"block.pills","as":"pill","tag":"div"},"style":{"base":{"display":"flex","flexWrap":"wrap","gap":"0.375rem"}}}
::::::::::::: paragraph {"id":"rb-pill","props":{"tag":"span"},"style":{"base":{"display":"inline-flex","alignItems":"center","height":"1.25rem","paddingInline":"0.45rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.sm","fontSize":"token:text.xs","color":"token:color.muted","whiteSpace":"nowrap"}},"bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"rb-desc","style":{"base":{"marginTop":"0.5rem"}},"bind":{"text":"block.description","visible":"block.description"}}
:::::::::::

::::::::::: table {"id":"rb-table","props":{"header":true},"style":{"base":{"marginTop":"0.75rem"}},"bind":{"rows":"block.table","visible":"block.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: component {"id":"rb-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"rb-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"rb-toc-in","style":{"base":{"position":"sticky","top":"3.5rem","maxHeight":"calc(100dvh - 3.5rem)","overflowY":"auto","scrollbarWidth":"thin","paddingTop":"2.8125rem","paddingBottom":"2.5rem"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"rb-toc-list","props":{"source":"cms-block-categories","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"content":"\"On this page\"","display":"block","marginBottom":"0.375rem","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink"}}}
:::::::: link {"id":"rb-toc-link","style":{"base":{"display":"block","paddingBlock":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"},"is-current":{"color":"token:color.ink"}},"bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"rb-footer","props":{"ref":"docs-footer"}}
::::
:::
