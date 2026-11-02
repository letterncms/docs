# docs

The documentation site, built with the CMS, and the source of truth for how the product behaves. `README.md` says how to run it from a clean clone. Not a package: `composer.json` says what it needs from a release.

- Describe the product as it is, in every language. Search for every name you touch.
- The product's name is plain text here.
- **No plan files.** No specs, research or progress notes in the repository.
- `plugins/reading-time` is the worked example of a site's own plugin. After changing it, run `pnpm install` and `pnpm build` in its folder and commit `dist/`.
- Write for someone new: what it is and why first, then a picture, then the steps. Files, YAML and APIs go under a closing "For developers" heading.
- Pictures of the admin come from `screens.json`: add a shot there, then `./dev screenshots docs <name>` in the workspace. Diagrams are Custom HTML blocks using the `docs-fig` classes in `content/design/custom.css`, so they follow light and dark.
