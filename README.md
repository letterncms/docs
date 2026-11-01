# Docs

The documentation site, built with the CMS: content in `content/`, settings in `config/`. Most changes are to the Markdown files in `content/collections/docs/`.

To see it running, you need PHP 8.4 and Composer:

```bash
git clone https://github.com/letterncms/docs
cd docs
composer install
php cms install --plugins=none
php cms serve
```
