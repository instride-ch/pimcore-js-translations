Dynamic or Static Translations
==============================

## Dynamic Translations

Pimcore's translation system is dynamic and therefore using dynamic translations is recommended as well. The dynamically
generated translations can be accessed under `https://your-domain.com/translations/pimcore`. The response of that route
will be automatically updated once you change shared translation values in the Pimcore interface.

By using dynamic translations, your client will be able to mutate any translations in a client application by himself.
This approach has its drawbacks though. Every time a translation changes, the symfony cache will be revalidated and
therefore slows down your application. Also, the user has to load an entire translation domain, which impacts
performance more or less, depending on its size.

## Static Translations

The more performant approach are static translations. In order to use them, you have to first
[dump](06-dump_translations_via_cli_command.md) all currently available Pimcore translations. Then you can generate
JavaScript files for each domain and locale with following command.

``` bash
$ php bin/console bazinga:js-translation:dump [target] [--format=js|json] [--pattern=/translations/{domain}.{_format}] [--merge-domains]
```

By default the files will be created in `/web/js`. More info about this command can be found
[here](https://github.com/willdurand/BazingaJsTranslationBundle/blob/master/Resources/doc/index.md#the-dump-command).
