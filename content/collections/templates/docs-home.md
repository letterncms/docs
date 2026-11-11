---
id: 01m6a3docshome000000000000
title: 'Docs home'
status: published
published_at: '2026-10-30T12:00:00+00:00'
position: 6
description: 'Search, where to start, and every section.'
collections:
  - docs
created_at: '2026-10-30T12:00:00+00:00'
updated_at: '2026-11-02T12:00:00+00:00'
---

::: box {"id":"h-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: component {"id":"h-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"h-shell","label":"Columns","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1},"lg":{"display":"grid","gridTemplateColumns":"14rem minmax(0, 1fr)","columnGap":"clamp(2rem, 4vw, 4.5rem)"}}}
::::: component {"id":"h-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"h-main","props":{"tag":"main"},"anchor":"main","style":{"base":{"minWidth":"0","maxWidth":"56rem","paddingTop":"clamp(2rem,4vw,3.5rem)","paddingBottom":"clamp(4rem,7vw,6rem)"}}}
:::::: box {"id":"h-hero"}
::::::: heading {"id":"h-title","props":{"level":"1","text":"Lettern documentation"},"style":{"base":{"fontSize":"token:text.5xl","lineHeight":"token:leading.display","letterSpacing":"token:tracking.display","fontWeight":"token:weight.heading","color":"token:color.ink"}}}
:::::::

::::::: box {"id":"h-body","class":"cms-prose docs-lead","style":{"base":{"marginTop":"0.875rem","maxWidth":"38rem"}}}
:::::::: outlet {"id":"h-outlet"}
::::::::
:::::::

::::::: search {"id":"h-search","props":{"label":"Search the docs","placeholder":"Search the docs","empty":"Nothing found. Try other words.","shortcut":true},"style":{"base":{"display":"flex","width":"100%","maxWidth":"32rem","height":"3rem","marginTop":"1.75rem"}},"class":"docs-search docs-search--big"}
:::::::
::::::

:::::: box {"id":"h-start","props":{"tag":"section"},"attrs":{"aria-labelledby":"start-here"},"style":{"base":{"marginTop":"clamp(2.5rem,4vw,3.5rem)"}}}
::::::: heading {"id":"h-start-h","props":{"level":"2","text":"Start here"},"anchor":"start-here","style":{"base":{"marginBottom":"1rem","fontSize":"token:text.lg","lineHeight":"1.4","fontWeight":"token:weight.heading","color":"token:color.ink"}}}
:::::::

::::::: box {"id":"h-cards","style":{"base":{"display":"grid","gridTemplateColumns":"repeat(2,minmax(0,1fr))","gap":"0.75rem"},"mobile":{"gridTemplateColumns":"minmax(0,1fr)"}}}
:::::::: link {"id":"h-c1","props":{"url":"/getting-started/installation"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","overflow":"hidden","transition":"background-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::::: box {"id":"h-c1-p","style":{"base":{"position":"relative","height":"12.5rem","overflow":"hidden","paddingTop":"1.5rem","paddingLeft":"1.5rem"},"mobile":{"height":"10rem"}}}
:::::::::: image {"id":"h-c1-i","props":{"image":"/media/screens/dashboard.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"200%","maxWidth":"none","borderRadius":"token:radius.lg","overflow":"hidden","boxShadow":"0 0 0 1px rgb(43 41 38 / 0.08), 0 8px 24px rgb(43 41 38 / 0.06)","backgroundColor":"#ffffff"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c1-x","style":{"base":{"padding":"1rem 1.25rem 1.25rem"}}}
:::::::::: paragraph {"id":"h-c1-t","props":{"text":"Install Lettern","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
::::::::::

:::::::::: paragraph {"id":"h-c1-d","props":{"text":"Upload a zip to any PHP host, or use Composer. A few minutes, start to finish.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c2","props":{"url":"/getting-started/quick-start"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","overflow":"hidden","transition":"background-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::::: box {"id":"h-c2-p","style":{"base":{"position":"relative","height":"12.5rem","overflow":"hidden","paddingTop":"1.5rem","paddingLeft":"1.5rem"},"mobile":{"height":"10rem"}}}
:::::::::: image {"id":"h-c2-i","props":{"image":"/media/screens/editor.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"200%","maxWidth":"none","borderRadius":"token:radius.lg","overflow":"hidden","boxShadow":"0 0 0 1px rgb(43 41 38 / 0.08), 0 8px 24px rgb(43 41 38 / 0.06)","backgroundColor":"#ffffff"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c2-x","style":{"base":{"padding":"1rem 1.25rem 1.25rem"}}}
:::::::::: paragraph {"id":"h-c2-t","props":{"text":"Build your first page","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
::::::::::

:::::::::: paragraph {"id":"h-c2-d","props":{"text":"Write, add blocks and publish, right on the page itself.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c3","props":{"url":"/design/design-system"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","overflow":"hidden","transition":"background-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::::: box {"id":"h-c3-p","style":{"base":{"position":"relative","height":"12.5rem","overflow":"hidden","paddingTop":"1.5rem","paddingLeft":"1.5rem"},"mobile":{"height":"10rem"}}}
:::::::::: image {"id":"h-c3-i","props":{"image":"/media/screens/design-system.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"200%","maxWidth":"none","borderRadius":"token:radius.lg","overflow":"hidden","boxShadow":"0 0 0 1px rgb(43 41 38 / 0.08), 0 8px 24px rgb(43 41 38 / 0.06)","backgroundColor":"#ffffff"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c3-x","style":{"base":{"padding":"1rem 1.25rem 1.25rem"}}}
:::::::::: paragraph {"id":"h-c3-t","props":{"text":"Make it yours","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
::::::::::

:::::::::: paragraph {"id":"h-c3-d","props":{"text":"Pick colors, fonts and spacing once. Every page follows.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c4","props":{"url":"/agents/assistant"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","overflow":"hidden","transition":"background-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::::: box {"id":"h-c4-p","style":{"base":{"position":"relative","height":"12.5rem","overflow":"hidden","paddingTop":"1.5rem","paddingLeft":"1.5rem"},"mobile":{"height":"10rem"}}}
:::::::::: box {"id":"h-c4-chat","attrs":{"aria-hidden":"true"},"style":{"base":{"display":"flex","flexDirection":"column","gap":"0.625rem","paddingRight":"1.5rem"}}}
::::::::::: paragraph {"id":"h-c4-q","props":{"text":"Add a pricing section with three plans to the home page","tag":"span"},"style":{"base":{"maxWidth":"17rem","padding":"0.625rem 0.875rem","borderRadius":"1rem","fontSize":"token:text.sm","lineHeight":"1.35","boxShadow":"0 0 0 1px rgb(43 41 38 / 0.06)","alignSelf":"flex-end","backgroundColor":"token:color.yellow","color":"token:color.on-yellow","borderBottomRightRadius":"0.375rem"}}}
:::::::::::

::::::::::: box {"id":"h-c4-s","style":{"base":{"display":"flex","alignItems":"center","gap":"0.5rem","fontSize":"token:text.xs","lineHeight":"1rem","color":"token:color.muted"}}}
:::::::::::: icon {"id":"h-c4-s-i","props":{"icon":"check-circle"},"style":{"base":{"width":"14px","height":"14px","color":"token:color.ink"}}}
::::::::::::

:::::::::::: paragraph {"id":"h-c4-s-t","props":{"text":"entries/update · Home","tag":"span"},"style":{"base":{"fontFamily":"token:font.mono"}}}
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"h-c4-a","props":{"text":"Done. Home now has a Pricing section with Starter, Studio and Agency. Publish it?","tag":"span"},"style":{"base":{"maxWidth":"17rem","padding":"0.625rem 0.875rem","borderRadius":"1rem","fontSize":"token:text.sm","lineHeight":"1.35","boxShadow":"0 0 0 1px rgb(43 41 38 / 0.06)","backgroundColor":"token:color.raised","color":"token:color.ink","borderBottomLeftRadius":"0.375rem"}}}
:::::::::::
::::::::::
:::::::::

::::::::: box {"id":"h-c4-x","style":{"base":{"padding":"1rem 1.25rem 1.25rem"}}}
:::::::::: paragraph {"id":"h-c4-t","props":{"text":"Work with AI","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
::::::::::

:::::::::: paragraph {"id":"h-c4-d","props":{"text":"Ask the assistant, or connect Claude, ChatGPT or Cursor to your site.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::
:::::::
::::::

:::::: box {"id":"h-topics","props":{"tag":"section"},"attrs":{"aria-labelledby":"all-topics"},"style":{"base":{"marginTop":"clamp(3rem,5vw,4.5rem)"}}}
::::::: heading {"id":"h-topics-h","props":{"level":"2","text":"Browse by topic"},"anchor":"all-topics","style":{"base":{"marginBottom":"1rem","fontSize":"token:text.lg","lineHeight":"1.4","fontWeight":"token:weight.heading","color":"token:color.ink"}}}
:::::::

::::::: repeat {"id":"h-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"style":{"base":{"display":"grid","gridTemplateColumns":"repeat(2,minmax(0,1fr))","gap":"0 2.5rem"},"mobile":{"gridTemplateColumns":"minmax(0,1fr)"}}}
:::::::: link {"id":"h-sec","style":{"base":{"display":"block","paddingBlock":"1rem","borderTop":"1px solid token:color.line","transition":"color 150ms ease"},"hover":{"color":"token:color.ink"}},"bind":{"url":"item.url","visible":"item.children"},"class":"docs-topic"}
::::::::: paragraph {"id":"h-sec-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}},"bind":{"text":"item.title"}}
:::::::::

::::::::: paragraph {"id":"h-sec-d","props":{"tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"pretty"}},"bind":{"text":"item.description","visible":"item.description"}}
:::::::::
::::::::
:::::::
::::::
:::::
::::

:::: component {"id":"h-footer","props":{"ref":"docs-footer"}}
::::
:::
