---
id: 01m6a3docshome000000000000
title: 'Docs home'
status: published
published_at: '2026-10-30T12:00:00+00:00'
position: 6
description: 'Search, the ways in, and a map of every section.'
collections:
  - docs
created_at: '2026-10-30T12:00:00+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"h-root","label":"Docs","style":{"base":{"display":"flex","flexDirection":"column","minHeight":"100dvh"}}}
:::: pattern {"id":"h-header","props":{"ref":"docs-header"}}
::::

:::: box {"id":"h-main","props":{"tag":"main"},"style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","flexGrow":1,"paddingTop":"clamp(2.5rem,4.4vw,4rem)","paddingBottom":"clamp(4rem,7vw,6rem)"}},"anchor":"main"}
::::: box {"id":"h-hero"}
:::::: heading {"id":"h-title","props":{"level":"1","text":"Lettern documentation"},"style":{"base":{"fontSize":"token:text.5xl","lineHeight":"token:leading.display","letterSpacing":"token:tracking.display","fontWeight":"token:weight.heading","color":"token:color.ink"}}}
::::::

:::::: paragraph {"id":"h-lead","props":{"text":"From first install to your own plugins.","tag":"p"},"style":{"base":{"fontSize":"token:text.5xl","lineHeight":"token:leading.display","letterSpacing":"token:tracking.display","fontWeight":"token:weight.heading","color":"token:color.faint","textWrap":"balance"}}}
::::::

:::::: search {"id":"h-search","props":{"label":"Search the docs","placeholder":"Search the docs","empty":"Nothing found. Try other words.","shortcut":true},"style":{"base":{"display":"flex","width":"100%","maxWidth":"32rem","height":"3rem","marginTop":"1.5rem"}},"class":"docs-search docs-search--big"}
::::::
:::::

::::: box {"id":"h-start","style":{"base":{"display":"grid","gridTemplateColumns":"repeat(4,minmax(0,1fr))","gap":"0.5rem","marginTop":"clamp(2rem,3.4vw,3rem)"},"tablet":{"gridTemplateColumns":"repeat(2,minmax(0,1fr))"},"mobile":{"gridTemplateColumns":"minmax(0,1fr)"}}}
:::::: link {"id":"h-s1","props":{"url":"/getting-started/installation"},"style":{"base":{"display":"block","padding":"1.125rem 1.25rem 1.25rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::: paragraph {"id":"h-s1-t","props":{"text":"Install","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
:::::::

::::::: paragraph {"id":"h-s1-d","props":{"text":"On any PHP host, by upload or with Composer.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"balance"}}}
:::::::
::::::

:::::: link {"id":"h-s2","props":{"url":"/getting-started/quick-start"},"style":{"base":{"display":"block","padding":"1.125rem 1.25rem 1.25rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::: paragraph {"id":"h-s2-t","props":{"text":"Build a site","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
:::::::

::::::: paragraph {"id":"h-s2-d","props":{"text":"From an empty install to a published page.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"balance"}}}
:::::::
::::::

:::::: link {"id":"h-s3","props":{"url":"/agents/mcp"},"style":{"base":{"display":"block","padding":"1.125rem 1.25rem 1.25rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::: paragraph {"id":"h-s3-t","props":{"text":"Connect an agent","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
:::::::

::::::: paragraph {"id":"h-s3-d","props":{"text":"Let an AI agent build and edit your site over MCP.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"balance"}}}
:::::::
::::::

:::::: link {"id":"h-s4","props":{"url":"/plugins/your-first-plugin"},"style":{"base":{"display":"block","padding":"1.125rem 1.25rem 1.25rem","backgroundColor":"token:color.panel","borderRadius":"token:radius.xl","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.panel-hover"}}}
::::::: paragraph {"id":"h-s4-t","props":{"text":"Write a plugin","tag":"span"},"style":{"base":{"display":"block","fontSize":"token:text.base","lineHeight":"1.5","fontWeight":"token:weight.medium","color":"token:color.ink"}}}
:::::::

::::::: paragraph {"id":"h-s4-d","props":{"text":"A complete, working example, step by step.","tag":"span"},"style":{"base":{"display":"block","marginTop":"0.25rem","fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted","textWrap":"balance"}}}
:::::::
::::::
:::::

::::: box {"id":"h-map","props":{"tag":"nav"},"attrs":{"aria-label":"All sections"},"style":{"base":{"display":"grid","gridTemplateColumns":"repeat(4,minmax(0,1fr))","gap":"3rem 2rem","marginTop":"clamp(3rem,5vw,4.5rem)"},"tablet":{"gridTemplateColumns":"repeat(3,minmax(0,1fr))"},"mobile":{"gridTemplateColumns":"repeat(2,minmax(0,1fr))","gap":"2.5rem 1.25rem"}}}
:::::: repeat {"id":"h-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"},"style":{"base":{"display":"contents"}}}
::::::: box {"id":"h-sec","bind":{"visible":"item.children"}}
:::::::: box {"id":"h-sec-h","props":{"tag":"h2"},"style":{"base":{"fontSize":"token:text.sm","lineHeight":"1.25rem","letterSpacing":"token:tracking.normal","fontWeight":500}}}
::::::::: link {"id":"h-sec-t","style":{"base":{"display":"block","marginBottom":"0.5rem","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"color":"token:color.muted"}},"bind":{"label":"item.title","url":"item.url"}}
:::::::::
::::::::

:::::::: repeat {"id":"h-sec-l","props":{"source":"children","of":"item","as":"doc","tag":"ul"}}
::::::::: box {"id":"h-sec-li","props":{"tag":"li"}}
:::::::::: link {"id":"h-sec-a","style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}},"bind":{"label":"doc.title","url":"doc.url"}}
::::::::::
:::::::::
::::::::
:::::::
::::::

:::::: box {"id":"h-web"}
::::::: box {"id":"h-web-h","props":{"tag":"h2"},"style":{"base":{"fontSize":"token:text.sm","lineHeight":"1.25rem","letterSpacing":"token:tracking.normal","fontWeight":500}}}
:::::::: link {"id":"h-web-t","props":{"label":"On the website","url":"https://lettern.org"},"style":{"base":{"display":"block","marginBottom":"0.5rem","fontSize":"token:text.sm","lineHeight":"1.25rem","fontWeight":500,"color":"token:color.ink","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"color":"token:color.muted"}}}
::::::::
:::::::

::::::: box {"id":"h-web-l","props":{"tag":"ul"}}
:::::::: box {"id":"h-web-li0","props":{"tag":"li"}}
::::::::: link {"id":"h-web-a0","props":{"label":"Download","url":"https://lettern.org/download"},"style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}}}
:::::::::
::::::::

:::::::: box {"id":"h-web-li1","props":{"tag":"li"}}
::::::::: link {"id":"h-web-a1","props":{"label":"Plugin store","url":"https://lettern.org/store"},"style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}}}
:::::::::
::::::::

:::::::: box {"id":"h-web-li2","props":{"tag":"li"}}
::::::::: link {"id":"h-web-a2","props":{"label":"Changelog","url":"https://lettern.org/changelog"},"style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}}}
:::::::::
::::::::

:::::::: box {"id":"h-web-li3","props":{"tag":"li"}}
::::::::: link {"id":"h-web-a3","props":{"label":"Support","url":"https://lettern.org/support"},"style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}}}
:::::::::
::::::::

:::::::: box {"id":"h-web-li4","props":{"tag":"li"}}
::::::::: link {"id":"h-web-a4","props":{"label":"Community","url":"https://lettern.org/community"},"style":{"base":{"color":"token:color.muted","fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","display":"inline-block","paddingBlock":"0.1875rem"},"hover":{"color":"token:color.ink"}}}
:::::::::
::::::::
:::::::
::::::
:::::

::::: box {"id":"h-about","style":{"base":{"marginTop":"clamp(4rem,7vw,6rem)"}}}
:::::: heading {"id":"h-about-t","props":{"level":"2","text":"What makes Lettern different"},"style":{"base":{"marginBottom":"1.25rem"}}}
::::::

:::::: box {"id":"h-body","style":{"base":{"minWidth":"0"}},"class":"cms-prose docs-about"}
::::::: outlet {"id":"h-outlet","props":{"permalinks":true}}
:::::::
::::::
:::::
::::

:::: pattern {"id":"h-footer","props":{"ref":"docs-footer"}}
::::
:::
