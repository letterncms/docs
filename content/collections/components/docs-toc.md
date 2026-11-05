---
id: 01m5x8whe3hdz8jfa8x801k9kb
title: 'On this page'
status: published
published_at: '2026-10-26T23:31:46+00:00'
position: 2
synced: true
category: Docs
description: 'The page’s headings; follows the section in view.'
created_at: '2026-10-26T23:31:46+00:00'
updated_at: '2026-10-30T12:00:00+00:00'
---

::: box {"id":"dt","props":{"tag":"aside"},"label":"On this page","style":{"base":{"display":"none"},"xl":{"display":"block"}},"attrs":{"aria-label":"On this page"}}
:::: box {"id":"dt-in","style":{"base":{"position":"sticky","top":"2xl","maxHeight":"vh-100","overflowY":"auto","paddingTop":"xl","paddingBottom":"xl"}},"logic":{"behaviors":{"spy":{"offset":96}}}}
::::: repeat {"id":"dt-list","props":{"source":"headings","tag":"nav","depth":"3"},"style":{"base":{"display":"flex","flexDirection":"column"},"before":{"display":"block","marginBottom":"2xs","fontSize":"sm","fontWeight":"medium","color":"foreground"}}}
:::::: link {"id":"dt-link","style":{"base":{"display":"block","paddingBlock":"2xs","fontSize":"sm","color":"foreground-muted","transitionProperty":"colors","transitionDuration":"faster","transitionTimingFunction":"out"},"hover":{"color":"foreground"},"is-sub":{"paddingLeft":"sm"},"is-current":{"color":"foreground"}},"bind":{"label":"item.text","url":"item.url","state:sub":"item.level|is:3"}}
::::::
:::::
::::
:::
