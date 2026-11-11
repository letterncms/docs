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

::: box {"id":"t-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: component {"id":"t-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"t-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"},"xl":{"gridTemplateColumns":"14rem minmax(0, 1fr) 11.5rem"}}}
::::: component {"id":"t-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"t-main","props":{"tag":"main"},"label":"Main","style":{"base":{"minWidth":"0","paddingTop":"1.5rem","paddingBottom":"5rem"},"lg":{"paddingTop":"2.5rem"}},"anchor":"main"}
:::::: box {"id":"t-article","props":{"tag":"article"},"label":"Article","style":{"base":{"maxWidth":"46rem","marginInline":"auto"}}}
::::::: component {"id":"t-head","props":{"ref":"docs-page-head"}}
:::::::

::::::: box {"id":"t-otp","props":{"tag":"details"},"style":{"base":{"marginBottom":"2rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.lg","paddingInline":"1rem"},"xl":{"display":"none"}},"class":"docs-otp"}
:::::::: box {"id":"t-otp-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","minHeight":"2.75rem","fontSize":"token:text.sm","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"t-otp-t","props":{"text":"On this page","tag":"span"}}
:::::::::

::::::::: icon {"id":"t-otp-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: repeat {"id":"t-otp-list","props":{"source":"headings","tag":"nav","depth":"3"},"style":{"base":{"display":"grid","paddingBottom":"0.75rem"}},"attrs":{"aria-label":"On this page"}}
::::::::: link {"id":"t-otp-link","style":{"base":{"display":"block","paddingBlock":"0.3125rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"},"hover":{"color":"token:color.ink"},"is-sub":{"paddingLeft":"0.75rem"}},"bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
:::::::::
::::::::
:::::::

::::::: box {"id":"t-body","props":{"prose":true},"label":"Body"}
:::::::: outlet {"id":"t-outlet","props":{"permalinks":true}}
::::::::
:::::::

::::::: repeat {"id":"t-kids","props":{"source":"children","of":"entry","as":"doc","tag":"nav"},"label":"Pages in this section","style":{"base":{"display":"grid","gridTemplateColumns":"repeat(2,minmax(0,1fr))","gap":"0.5rem","marginTop":"2rem"},"mobile":{"gridTemplateColumns":"minmax(0,1fr)"}},"attrs":{"aria-label":"In this section"}}
:::::::: link {"id":"t-kid","style":{"base":{"display":"block","padding":"1rem 1.125rem 1.125rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","transition":"background-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}},"bind":{"url":"doc.url"}}
::::::::: paragraph {"id":"t-kid-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}},"bind":{"text":"doc.title"}}
:::::::::

::::::::: paragraph {"id":"t-kid-d","props":{"tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}},"bind":{"text":"doc.description","visible":"doc.description"}}
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
