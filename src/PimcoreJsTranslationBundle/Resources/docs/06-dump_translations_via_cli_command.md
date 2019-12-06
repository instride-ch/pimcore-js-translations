Dump Translations via CLI Command
=================================

You can dump all currently available Pimcore translations with this CLI command. The CLI command will create the XLIFF
translation files in `@PimcoreJsTranslationBundle/src/PimcoreJsTranslationBundle/Resources/translations`
for all in your Pimcore project's system settings enabled locales.

``` bash
$ php bin/console pimcore:translations:dump-js-translations
```

After that you can dump the JavaScript files into your `/web` directory, as described
[here](04-dynamic_or_static_translations.md#static-translations).
