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

::: box {"id":"h-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"screen"}}}
:::: pattern {"id":"h-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"h-shell","label":"Columns","style":{"base":{"width":"full","maxWidth":"content","marginInline":"auto","flexGrow":"1","paddingInline":"gutter"},"lg":{"display":"grid","gridTemplateColumns":"6xl 1fr","columnGap":"3xl"}}}
::::: pattern {"id":"h-sidebar","props":{"ref":"docs-sidebar"}}
:::::

::::: box {"id":"h-main","props":{"tag":"main"},"anchor":"main","style":{"base":{"minWidth":"0","maxWidth":"narrow","paddingTop":"2xl","paddingBottom":"4xl"}}}
:::::: box {"id":"h-hero"}
::::::: heading {"id":"h-title","props":{"level":"1","text":"Lettern documentation"},"style":{"base":{"fontSize":"2xl","lineHeight":"snug","letterSpacing":"tight","fontWeight":"regular","color":"foreground"}}}
:::::::

::::::: box {"id":"h-body","style":{"base":{"marginTop":"sm","maxWidth":"narrow","flow":"prose","text":"lead","color":"foreground-muted"}}}
:::::::: outlet {"id":"h-outlet"}
::::::::
:::::::

::::::: search {"id":"h-search","props":{"label":"Search the docs","placeholder":"Search the docs","empty":"Nothing found. Try other words.","shortcut":true},"style":{"base":{"display":"flex","width":"full","maxWidth":"narrow","height":"2xl","marginTop":"lg"}},"class":"docs-search docs-search--big"}
:::::::
::::::

:::::: box {"id":"h-start","props":{"tag":"section"},"attrs":{"aria-labelledby":"start-here"},"style":{"base":{"marginTop":"2xl"}}}
::::::: heading {"id":"h-start-h","props":{"level":"2","text":"Start here"},"anchor":"start-here","style":{"base":{"marginBottom":"md","fontSize":"base","lineHeight":"normal","fontWeight":"regular","color":"foreground"}}}
:::::::

::::::: box {"id":"h-cards","style":{"base":{"display":"grid","gridTemplateColumns":"2","gap":"sm"},"max-md":{"gridTemplateColumns":"1fr"}}}
:::::::: link {"id":"h-c1","props":{"url":"/getting-started/installation"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"background-muted","borderRadius":"lg","overflow":"hidden","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}}}
::::::::: box {"id":"h-c1-p","style":{"base":{"position":"relative","height":"6xl","overflow":"hidden","paddingTop":"lg","paddingLeft":"lg"},"max-md":{"height":"5xl"}}}
:::::::::: image {"id":"h-c1-i","props":{"image":"/media/screens/dashboard.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"full","maxWidth":"none","borderRadius":"md","overflow":"hidden","boxShadow":"md","backgroundColor":"white"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c1-x","style":{"base":{"padding":"md md md"}}}
:::::::::: paragraph {"id":"h-c1-t","props":{"text":"Install Lettern","tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}}}
::::::::::

:::::::::: paragraph {"id":"h-c1-d","props":{"text":"Upload a zip to any PHP host, or use Composer. A few minutes, start to finish.","tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c2","props":{"url":"/getting-started/quick-start"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"background-muted","borderRadius":"lg","overflow":"hidden","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}}}
::::::::: box {"id":"h-c2-p","style":{"base":{"position":"relative","height":"6xl","overflow":"hidden","paddingTop":"lg","paddingLeft":"lg"},"max-md":{"height":"5xl"}}}
:::::::::: image {"id":"h-c2-i","props":{"image":"/media/screens/editor.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"full","maxWidth":"none","borderRadius":"md","overflow":"hidden","boxShadow":"md","backgroundColor":"white"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c2-x","style":{"base":{"padding":"md md md"}}}
:::::::::: paragraph {"id":"h-c2-t","props":{"text":"Build your first page","tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}}}
::::::::::

:::::::::: paragraph {"id":"h-c2-d","props":{"text":"Write, add blocks and publish, right on the page itself.","tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c3","props":{"url":"/design/design-system"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"background-muted","borderRadius":"lg","overflow":"hidden","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}}}
::::::::: box {"id":"h-c3-p","style":{"base":{"position":"relative","height":"6xl","overflow":"hidden","paddingTop":"lg","paddingLeft":"lg"},"max-md":{"height":"5xl"}}}
:::::::::: image {"id":"h-c3-i","props":{"image":"/media/screens/design-system.webp","alt":"","sizes":"(min-width: 1024px) 50vw, 100vw"},"style":{"base":{"display":"block","width":"full","maxWidth":"none","borderRadius":"md","overflow":"hidden","boxShadow":"md","backgroundColor":"white"}}}
::::::::::
:::::::::

::::::::: box {"id":"h-c3-x","style":{"base":{"padding":"md md md"}}}
:::::::::: paragraph {"id":"h-c3-t","props":{"text":"Make it yours","tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}}}
::::::::::

:::::::::: paragraph {"id":"h-c3-d","props":{"text":"Pick colors, fonts and spacing once. Every page follows.","tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::

:::::::: link {"id":"h-c4","props":{"url":"/agents/assistant"},"style":{"base":{"display":"flex","flexDirection":"column","backgroundColor":"background-muted","borderRadius":"lg","overflow":"hidden","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"backgroundColor":"background-emphasis"}}}
::::::::: box {"id":"h-c4-p","style":{"base":{"position":"relative","height":"6xl","overflow":"hidden","paddingTop":"lg","paddingLeft":"lg"},"max-md":{"height":"5xl"}}}
:::::::::: box {"id":"h-c4-chat","attrs":{"aria-hidden":"true"},"style":{"base":{"display":"flex","flexDirection":"column","gap":"xs","paddingRight":"lg"}}}
::::::::::: paragraph {"id":"h-c4-q","props":{"text":"Add a pricing section with three plans to the home page","tag":"span"},"style":{"base":{"maxWidth":"7xl","padding":"xs sm","borderRadius":"xl","fontSize":"sm","lineHeight":"normal","boxShadow":"sm","alignSelf":"end","borderBottomRightRadius":"sm","scheme":"primary"}}}
:::::::::::

::::::::::: box {"id":"h-c4-s","style":{"base":{"display":"flex","alignItems":"center","gap":"xs","fontSize":"xs","color":"foreground-muted"}}}
:::::::::::: icon {"id":"h-c4-s-i","props":{"icon":"check-circle"},"style":{"base":{"width":"sm","height":"sm","color":"foreground"}}}
::::::::::::

:::::::::::: paragraph {"id":"h-c4-s-t","props":{"text":"entries/update · Home","tag":"span"},"style":{"base":{"fontFamily":"mono"}}}
::::::::::::
:::::::::::

::::::::::: paragraph {"id":"h-c4-a","props":{"text":"Done. Home now has a Pricing section with Starter, Studio and Agency. Publish it?","tag":"span"},"style":{"base":{"maxWidth":"7xl","padding":"xs sm","borderRadius":"xl","fontSize":"sm","lineHeight":"normal","boxShadow":"sm","backgroundColor":"surface","color":"foreground","borderBottomLeftRadius":"sm"}}}
:::::::::::
::::::::::
:::::::::

::::::::: box {"id":"h-c4-x","style":{"base":{"padding":"md md md"}}}
:::::::::: paragraph {"id":"h-c4-t","props":{"text":"Work with AI","tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}}}
::::::::::

:::::::::: paragraph {"id":"h-c4-d","props":{"text":"Ask the assistant, or connect Claude, ChatGPT or Cursor to your site.","tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}}}
::::::::::
:::::::::
::::::::
:::::::
::::::

:::::: box {"id":"h-topics","props":{"tag":"section"},"attrs":{"aria-labelledby":"all-topics"},"style":{"base":{"marginTop":"3xl"}}}
::::::: heading {"id":"h-topics-h","props":{"level":"2","text":"Browse by topic"},"anchor":"all-topics","style":{"base":{"marginBottom":"md","fontSize":"base","lineHeight":"normal","fontWeight":"regular","color":"foreground"}}}
:::::::

::::::: repeat {"id":"h-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"style":{"base":{"display":"grid","gridTemplateColumns":"2","gap":"0 xl"},"max-md":{"gridTemplateColumns":"1fr"}}}
:::::::: link {"id":"h-sec","style":{"base":{"display":"block","paddingBlock":"md","borderTopWidth":"1","borderStyle":"solid","borderColor":"border","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"}},"bind":{"url":"item.url","visible":"item.children"}}
::::::::: paragraph {"id":"h-sec-t","props":{"tag":"span"},"style":{"base":{"display":"block","fontSize":"base","lineHeight":"normal","fontWeight":"medium","color":"foreground"}},"bind":{"text":"item.title"}}
:::::::::

::::::::: paragraph {"id":"h-sec-d","props":{"tag":"span"},"style":{"base":{"display":"block","marginTop":"2xs","fontSize":"sm","color":"foreground-muted","textWrap":"pretty"}},"bind":{"text":"item.description","visible":"item.description"}}
:::::::::
::::::::
:::::::
::::::
:::::
::::

:::: pattern {"id":"h-footer","props":{"ref":"docs-footer"}}
::::
:::
