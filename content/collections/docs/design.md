---
id: 01m5wn8r8npxz0heybf16eex0k
title: Design
position: 3
description: 'Colors, fonts, templates and reusable designs: make the site look like yours.'
---
In Lettern you design in the browser, on the real site. There are no theme files to edit and nothing to build: what you see in the editor is what visitors get.

Design works in layers. The **design system** holds your colors, fonts and spacing. **Templates** frame your pages with a header, a footer and a layout. **Components** are pieces you reuse, like a card or a call to action. And every block can be styled, animated and made interactive on its own.

When a site needs more than that, such as a scroll timeline in GSAP or a WebGL scene, it keeps its own [scripts and styles](/design/code) beside the design, attaches them to blocks as [behaviors](/design/behaviors), and can [swap pages without loading them](/design/page-navigation). A whole site to start from, design and content together, is a [site kit](/design/site-kits).

::: html {"props":{"html":"<figure class=\"docs-fig\" role=\"img\" aria-label=\"Four layers of design: the design system, templates, components, and the styles on each block.\"><div class=\"docs-layers\"><div class=\"docs-layer\"><b>Design system</b><span><i class=\"docs-swatch\"></i><i class=\"docs-swatch docs-swatch--2\"></i><i class=\"docs-swatch docs-swatch--3\"></i><em>Aa</em></span><small>Colors, fonts and spacing for the whole site</small></div><div class=\"docs-layer\"><b>Templates</b><span><em>Header</em><em>Page content</em><em>Footer</em></span><small>The frame around your pages</small></div><div class=\"docs-layer\"><b>Components</b><span><em>Card</em><em>Call to action</em></span><small>Designs you reuse</small></div><div class=\"docs-layer\"><b>Blocks</b><span><em>Style</em><em>Animate</em><em>Interact</em></span><small>Every detail, on any block</small></div></div></figure>"}}
:::

Developers and AI agents change the very same design, through the API, MCP or the files in git. See [Project structure](/reference/project-structure).
