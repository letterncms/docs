---
id: 01m5wmrf4kp6mpg77rptqfmmpz
title: Introduction
position: 0
template: docs-home
description: 'Install, build, automate and extend Lettern, the free, open-source CMS for agencies and freelancers.'
---
Lettern is a CMS you install on any PHP host. Pages, templates, headers and footers share one live block editor, and the site is published as static HTML.

**Every action is an ability.** Creating an entry, uploading an image, changing a design token or publishing the site: each is a named action with a JSON schema, a permission and an audit trail. The admin, the REST API, the command line, MCP agents and the built-in assistant all call the same abilities, so they can never do more than the person behind them.

**The design is content, not code.** Templates and components are entries you design visually, and colours, type and spacing are tokens in `content/design/tokens.json`. Blocks style themselves with tokens and reuse components, so every page stays on brand, whoever builds it.

**Everything is a plugin.** The block editor, site rendering, SEO, media, forms, email, MCP and the assistant are written exactly like third-party plugins. Disable what you don't need, replace what you want to do differently.

**Built for ambitious sites.** Any block takes any CSS at any screen size and state. Interactions run on Alpine.js and animations on CSS and the Web Animations API, and each page loads only the JavaScript it uses.

**Static by default.** Pages are rendered to HTML files in `public/` when content changes and served without PHP. Forms and other dynamic features talk to small APIs.

**Your files, your git.** Configuration is YAML, and content can live in the database or as Markdown files with frontmatter, ready to commit.
