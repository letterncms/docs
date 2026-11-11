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

::: box {"id":"ra-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: component {"id":"ra-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"ra-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"},"xl":{"gridTemplateColumns":"14rem minmax(0, 1fr) 11.5rem"}}}
::::: component {"id":"ra-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"ra-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"1.5rem","paddingBottom":"5rem"},"lg":{"paddingTop":"2.5rem"}},"anchor":"main"}
:::::: box {"id":"ra-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"token:container.prose","marginInline":"auto"}}}
::::::: component {"id":"ra-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"ra-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"2rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","paddingInline":"1rem"},"xl":{"display":"none"}},"class":"docs-otp"}
:::::::: box {"id":"ra-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","minHeight":"2.75rem","fontSize":"token:text.sm","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"ra-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"ra-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: repeat {"id":"ra-otp-list","props":{"source":"cms-ability-groups","tag":"nav"},"style":{"base":{"display":"grid","paddingBottom":"0.75rem"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"ra-otp-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"}},"bind":{"label":"item.name","url":"#{item.id}"}}
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
:::::::::: box {"id":"ra-item","props":{"tag":"section"},"style":{"base":{"paddingBlock":"1.25rem","borderTop":"1px solid token:color.line"},"first":{"borderTop":"0"}},"bind":{"attr:id":"ability.id"}}
::::::::::: box {"id":"ra-row","style":{"base":{"display":"flex","flexWrap":"wrap","alignItems":"center","gap":"0.5rem"}}}
:::::::::::: paragraph {"id":"ra-name","props":{"tag":"span"},"style":{"base":{"fontFamily":"token:font.mono","fontSize":"0.875rem","fontWeight":500,"color":"token:color.ink"}},"bind":{"text":"ability.name"}}
::::::::::::

:::::::::::: repeat {"id":"ra-pills","props":{"source":"list","path":"ability.pills","as":"pill","tag":"div"},"style":{"base":{"display":"flex","flexWrap":"wrap","gap":"0.375rem"}}}
::::::::::::: paragraph {"id":"ra-pill","props":{"tag":"span"},"style":{"base":{"display":"inline-flex","alignItems":"center","height":"1.25rem","paddingInline":"0.45rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.sm","fontSize":"token:text.xs","color":"token:color.muted","whiteSpace":"nowrap"}},"bind":{"text":"{pill}"}}
:::::::::::::
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"ra-desc","style":{"base":{"marginTop":"0.5rem"}},"bind":{"text":"ability.description"}}
:::::::::::

::::::::::: table {"id":"ra-table","props":{"header":true},"style":{"base":{"marginTop":"0.75rem"}},"bind":{"rows":"ability.table","visible":"ability.table"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::

::::::: component {"id":"ra-foot","props":{"ref":"docs-page-foot"}}
:::::::
::::::
:::::

::::: box {"id":"ra-toc","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::::: box {"id":"ra-toc-in","style":{"base":{"position":"sticky","top":"3.5rem","maxHeight":"calc(100dvh - 3.5rem)","overflowY":"auto","scrollbarWidth":"thin","paddingTop":"2.8125rem","paddingBottom":"2.5rem"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::::: repeat {"id":"ra-toc-list","props":{"source":"cms-ability-groups","tag":"nav"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"content":"\"On this page\"","display":"block","marginBottom":"0.375rem","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink"}}}
:::::::: link {"id":"ra-toc-link","style":{"base":{"display":"block","paddingBlock":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"},"is-current":{"color":"token:color.ink"}},"bind":{"label":"item.name","url":"#{item.id}"}}
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"ra-footer","props":{"ref":"docs-footer"}}
::::
:::
