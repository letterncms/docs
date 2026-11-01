---
id: 01m5x8wdmv9rxq508ccjfdy5s4
title: 'Docs header'
status: published
published_at: '2026-10-26T23:31:42+00:00'
position: 0
synced: true
category: Docs
description: 'Logo, sections, search, light or dark, and the phone menu.'
created_at: '2026-10-26T23:31:42+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"dh","props":{"tag":"header"},"label":"Header","style":{"base":{"position":"sticky","top":"0","zIndex":50,"backgroundColor":"token:color.background","borderBottom":"1px solid token:color.line"}},"logic":{"data":{"nav":false},"on":[{"event":"keydown","mods":["window"],"key":"escape","actions":[{"do":"if","test":"nav","then":[{"do":"set","var":"nav","value":"false"},{"do":"lock","on":false}],"else":[]}]}],"states":{"nav":"nav"}}}
:::: box {"id":"dh-bar","label":"Bar","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","maxWidth":"81.25rem","marginInline":"auto","display":"flex","alignItems":"center","gap":"0.75rem","height":"3.5rem"},"tablet":{"gap":"0.25rem"}}}
::::: link {"id":"dh-logo","props":{"url":"/","label":""},"label":"Logo","style":{"base":{"display":"flex","alignItems":"center","gap":"0.5rem","paddingBlock":"0.5rem","marginRight":"0.75rem","flexShrink":0}},"attrs":{"aria-label":"Lettern Docs, home"}}
:::::: icon {"id":"dh-logo-mark","props":{"icon":"","svg":"<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><rect width=\"100\" height=\"100\" rx=\"22\" fill=\"#ffe100\"/><path fill=\"#0a0a0a\" d=\"M26 20h15v45h33v15H26z\"/><circle cx=\"62\" cy=\"39\" r=\"12.5\" fill=\"#0a0a0a\"/></svg>"},"label":"Symbol","style":{"base":{"display":"block","width":"22px","height":"22px","flexShrink":0}}}
::::::

:::::: icon {"id":"dh-logo-word","props":{"icon":"","svg":"<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 6472 1512\" fill=\"currentColor\"><path d=\"M4093 1512Q4223 1512 4323.5 1472.5Q4424 1433 4488.5 1360.5Q4553 1288 4577 1191L4331 1162Q4313 1210 4279.5 1242.5Q4246 1275 4199.5 1291Q4153 1307 4097 1307Q4011 1307 3946.5 1269Q3882 1231 3846.5 1158.5Q3814.5 1093.2 3811.4 1004H4589V922Q4589 775 4548 668.5Q4507 562 4435.5 493Q4364 424 4271.5 391Q4179 358 4076 358Q3916 358 3798 431Q3680 504 3615 634.5Q3550 765 3550 938Q3550 1113 3615.5 1242Q3681 1371 3803 1441.5Q3925 1512 4093 1512ZM1562 1512Q1692 1512 1792.5 1472.5Q1893 1433 1957.5 1360.5Q2022 1288 2046 1191L1800 1162Q1782 1210 1748.5 1242.5Q1715 1275 1668.5 1291Q1622 1307 1566 1307Q1480 1307 1415.5 1269Q1351 1231 1315.5 1158.5Q1283.5 1093.2 1280.4 1004H2058V922Q2058 775 2017 668.5Q1976 562 1904.5 493Q1833 424 1740.5 391Q1648 358 1545 358Q1385 358 1267 431Q1149 504 1084 634.5Q1019 765 1019 938Q1019 1113 1084.5 1242Q1150 1371 1272 1441.5Q1394 1512 1562 1512ZM5754 836Q5754 754 5784.5 697.5Q5815 641 5868.5 611Q5922 581 5991 581Q6093 581 6151 644.5Q6209 708 6209 820V1490H6472V779Q6472 645 6424.5 550.5Q6377 456 6291 407Q6205 358 6089 358Q5963 358 5881.5 413.5Q5800 469 5762 563H5749V372H5491V1490H5754ZM0 1490H927V1264H270V0H0ZM2753 372H2532V106H2269V372H2112V576H2269V1197Q2269 1340 2358 1422.5Q2447 1505 2603 1505Q2646 1505 2689 1498.5Q2732 1492 2774 1479L2729 1273Q2712 1277 2691 1280Q2670 1283 2653 1283Q2590 1283 2561 1251.5Q2532 1220 2532 1154V576H2753ZM3457 372H3236V106H2973V372H2816V576H2973V1197Q2973 1340 3062 1422.5Q3151 1505 3307 1505Q3350 1505 3393 1498.5Q3436 1492 3478 1479L3433 1273Q3416 1277 3395 1280Q3374 1283 3357 1283Q3294 1283 3265 1251.5Q3236 1220 3236 1154V576H3457ZM4727 1490H4990V834Q4990 762 5022.5 708Q5055 654 5112 623Q5169 592 5242 592Q5275 592 5311 596Q5347 600 5364 606V364Q5346 361 5318.5 359Q5291 357 5270 357Q5174 357 5099 409.5Q5024 462 4994 560H4982V372H4727ZM3812.4 827Q3817.5 763.9 3842 710.5Q3873 643 3933 603Q3993 563 4078 563Q4163 563 4220 603Q4277 643 4306 713.5Q4326.8 764 4332.7 827H3812.4ZM1281.4 827Q1286.5 763.9 1311 710.5Q1342 643 1402 603Q1462 563 1547 563Q1632 563 1689 603Q1746 643 1775 713.5Q1795.8 764 1801.7 827H1281.4Z\"/></svg>","label":"Lettern"},"style":{"base":{"display":"block","height":"14px","width":"auto","color":"token:color.ink"}}}
::::::

:::::: paragraph {"id":"dh-logo-docs","props":{"text":"Docs","tag":"span"},"style":{"base":{"fontSize":"token:text.sm","lineHeight":"1.25rem","color":"token:color.muted"}}}
::::::
:::::

::::: repeat {"id":"dh-tabs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"nav"},"label":"Sections","style":{"base":{"display":"flex","alignItems":"center","gap":"0.125rem"},"tablet":{"display":"none"}},"attrs":{"aria-label":"Sections"}}
:::::: link {"id":"dh-tab","style":{"base":{"color":"token:color.foreground","fontWeight":400,"fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","paddingInline":"0.75rem","paddingBlock":"0.375rem","borderRadius":"token:radius.md","display":"inline-block","whiteSpace":"nowrap"},"hover":{"backgroundColor":"token:color.ink/6"},"is-active":{"color":"token:color.ink","backgroundColor":"token:color.ink/6"}},"bind":{"label":"item.title","url":"item.url","visible":"item.children","state:active":"item.active"}}
::::::
:::::

::::: box {"id":"dh-end","style":{"base":{"marginLeft":"auto","display":"flex","alignItems":"center","gap":"0.125rem"},"tablet":{"marginRight":"-0.5rem"}}}
:::::: search {"id":"dh-search","props":{"label":"Search","placeholder":"Search the docs","empty":"Nothing found. Try other words.","shortcut":true,"compact":"mobile"},"style":{"base":{"height":"2rem","width":"8.5rem","marginRight":"0.25rem"},"xl":{"width":"11rem"},"mobile":{"width":"2.75rem","height":"2.75rem","marginRight":"0"}},"class":"docs-search"}
::::::

:::::: link {"id":"dh-web","props":{"label":"Website","url":"https://lettern.eu"},"style":{"base":{"color":"token:color.foreground","fontWeight":400,"fontSize":"token:text.sm","lineHeight":"1.25rem","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease","paddingInline":"0.75rem","paddingBlock":"0.375rem","borderRadius":"token:radius.md","display":"none","whiteSpace":"nowrap"},"hover":{"backgroundColor":"token:color.ink/6"},"xl":{"display":"inline-block"}}}
::::::

:::::: box {"id":"dh-gh","props":{"link":"https://github.com/letterncms"},"style":{"base":{"display":"none","placeItems":"center","width":"2rem","height":"2rem","borderRadius":"token:radius.md","color":"token:color.foreground","cursor":"pointer","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.ink/6"},"xl":{"display":"grid"}}}
::::::: icon {"id":"dh-gh-i","props":{"icon":"","svg":"<svg fill=\"currentColor\" viewBox=\"0 0 24 24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12\"/></svg>","label":"GitHub"},"style":{"base":{"display":"block","width":"16px","height":"16px"}}}
:::::::
::::::

:::::: box {"id":"dh-theme","props":{"tag":"button"},"label":"Light or dark","style":{"base":{"display":"grid","placeItems":"center","width":"2rem","height":"2rem","borderRadius":"token:radius.md","color":"token:color.foreground","cursor":"pointer","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.ink/6"},"tablet":{"width":"2.75rem","height":"2.75rem"}},"attrs":{"aria-label":"Switch between light and dark","title":"Light or dark"},"logic":{"on":[{"event":"click","actions":[{"do":"theme","mode":"toggle"}]}]}}
::::::: icon {"id":"dh-theme-moon","props":{"icon":"moon"},"style":{"base":{"width":"16px","height":"16px"},"dark":{"display":"none"}}}
:::::::

::::::: icon {"id":"dh-theme-sun","props":{"icon":"sun"},"style":{"base":{"display":"none","width":"16px","height":"16px"},"dark":{"display":"inline-flex"}}}
:::::::
::::::

:::::: button {"id":"dh-get","props":{"label":"Download","url":"https://lettern.eu/download","variant":"yellow"},"style":{"base":{"display":"none","height":"2rem","paddingInline":"0.75rem","marginLeft":"0.25rem"},"xl":{"display":"inline-flex"}}}
::::::

:::::: box {"id":"dh-menu","props":{"tag":"button"},"label":"Menu button","style":{"base":{"display":"grid","placeItems":"center","width":"2.75rem","height":"2.75rem","borderRadius":"token:radius.md","color":"token:color.ink","cursor":"pointer","transition":"color 150ms ease, background-color 150ms ease, border-color 150ms ease"},"hover":{"backgroundColor":"token:color.ink/6"},"lg":{"display":"none"}},"attrs":{"aria-label":"Menu","aria-controls":"docs-menu"},"logic":{"on":[{"event":"click","actions":[{"do":"toggle","var":"nav"},{"do":"if","test":"nav","then":[{"do":"lock","on":true}],"else":[{"do":"lock","on":false}]}]}],"attrs":{"aria-expanded":"nav"}}}
::::::: icon {"id":"dh-menu-i","props":{"icon":"list"},"style":{"base":{"width":"22px","height":"22px"}},"logic":{"show":"!nav"}}
:::::::

::::::: icon {"id":"dh-close-i","props":{"icon":"x"},"style":{"base":{"width":"22px","height":"22px"}},"logic":{"show":"nav"}}
:::::::
::::::
:::::
::::

:::: box {"id":"dh-sheet","props":{"tag":"nav"},"label":"Menu","style":{"base":{"display":"none"},"tablet":{"display":"block","position":"fixed","top":"calc(3.5rem + 1px)","left":"0","right":"0","bottom":"0","zIndex":49,"overflowY":"auto","overscrollBehavior":"contain","backgroundColor":"token:color.background"}},"attrs":{"aria-label":"Documentation"},"logic":{"show":"nav","transition":"fade"},"anchor":"docs-menu"}
::::: box {"id":"dh-sheet-in","style":{"base":{"width":"calc(100% - 2 * token:space.gutter)","marginInline":"auto","paddingTop":"0.25rem","paddingBottom":"2.5rem"}}}
:::::: repeat {"id":"dh-secs","props":{"source":"entries","collection":"docs","parent":"top","sort":"position","limit":20,"tag":"div"}}
::::::: box {"id":"dh-sec","props":{"tag":"details"},"style":{"base":{"borderBottom":"1px solid token:color.line"}},"bind":{"visible":"item.children","attr:open":"item.active"},"class":"docs-sec"}
:::::::: box {"id":"dh-sec-s","props":{"tag":"summary"},"style":{"base":{"display":"flex","alignItems":"center","justifyContent":"space-between","gap":"1rem","minHeight":"3rem","fontSize":"token:text.base","fontWeight":500,"color":"token:color.ink","cursor":"pointer"}},"class":"docs-sec__s"}
::::::::: paragraph {"id":"dh-sec-t","props":{"tag":"span"},"bind":{"text":"item.title"}}
:::::::::

::::::::: icon {"id":"dh-sec-c","props":{"icon":"caret-down-bold"},"style":{"base":{"width":"12px","height":"12px","color":"token:color.muted","transition":"rotate 200ms ease"}},"class":"docs-sec__c"}
:::::::::
::::::::

:::::::: box {"id":"dh-sec-l","style":{"base":{"paddingBottom":"0.75rem"}}}
::::::::: link {"id":"dh-sec-o","props":{"label":"Overview"},"style":{"base":{"display":"block","paddingBlock":"0.5rem","paddingInline":"0.75rem","marginInline":"-0.75rem","borderRadius":"token:radius.md","fontSize":"token:text.base","color":"token:color.foreground"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}},"bind":{"url":"item.url"}}
:::::::::

::::::::: repeat {"id":"dh-sec-ps","props":{"source":"children","of":"item","as":"doc","tag":"ul"}}
:::::::::: box {"id":"dh-sec-li","props":{"tag":"li"}}
::::::::::: link {"id":"dh-sec-p","style":{"base":{"display":"block","paddingBlock":"0.5rem","paddingInline":"0.75rem","marginInline":"-0.75rem","borderRadius":"token:radius.md","fontSize":"token:text.base","color":"token:color.foreground"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}},"bind":{"label":"doc.title","url":"doc.url"}}
:::::::::::
::::::::::
:::::::::
::::::::
:::::::
::::::

:::::: box {"id":"dh-sheet-end","style":{"base":{"display":"grid","gap":"0.125rem","marginTop":"0.75rem"}}}
::::::: link {"id":"dh-sheet-home","props":{"label":"Docs home","url":"/"},"style":{"base":{"display":"block","paddingBlock":"0.5rem","paddingInline":"0.75rem","marginInline":"-0.75rem","borderRadius":"token:radius.md","fontSize":"token:text.base","color":"token:color.foreground"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}}}
:::::::

::::::: link {"id":"dh-sheet-web","props":{"label":"Lettern website","url":"https://lettern.eu"},"style":{"base":{"display":"block","paddingBlock":"0.5rem","paddingInline":"0.75rem","marginInline":"-0.75rem","borderRadius":"token:radius.md","fontSize":"token:text.base","color":"token:color.foreground"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}}}
:::::::

::::::: link {"id":"dh-sheet-get","props":{"label":"Get Lettern","url":"https://lettern.eu/download"},"style":{"base":{"display":"block","paddingBlock":"0.5rem","paddingInline":"0.75rem","marginInline":"-0.75rem","borderRadius":"token:radius.md","fontSize":"token:text.base","color":"token:color.foreground"},"current":{"backgroundColor":"token:color.ink/6","color":"token:color.ink","fontWeight":500}}}
:::::::
::::::
:::::
::::
:::
