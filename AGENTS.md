# docs

The documentation site, built with the CMS, and the source of truth for how the product behaves. `README.md` says how to run it from a clean clone. Not a package: `composer.json` says what it needs from a release.

- Describe the product as it is, in every language. Search for every name you touch.
- The product's name is plain text here.
- **No plan files.** No specs, research or progress notes in the repository.
- `plugins/reading-time` is the worked example of a site's own plugin. After changing it, run `pnpm install` and `pnpm build` in its folder and commit `dist/`.
