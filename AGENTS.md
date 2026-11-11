# docs

The documentation site, built with the CMS, and the source of truth for how the product behaves. `README.md` says how to run it from a clean clone. Not a package: `composer.json` says what it needs from a release.

- The product's name is plain text here. The docs are in English only (`locales: [en]` in `config/site.yaml`): there are no translated pages to keep in step.
- `plugins/reading-time` is the worked example of a site's own plugin. After changing it, rebuild it and commit `dist/`: `./dev build` in the workspace (a `pnpm install` in its folder there would replace the workspace's links), or `pnpm install` and `pnpm build` in its folder in a lone clone.
- Write for someone new: what it is and why first, then a picture, then the steps. Files, YAML and APIs go under a closing "For developers" heading.
- Pictures of the admin come from `screens.json`: add a shot there, then `./dev screenshots docs <name>` in the workspace. Diagrams are Custom HTML blocks using the `docs-fig` classes in `content/design/custom.css`, so they follow light and dark.
