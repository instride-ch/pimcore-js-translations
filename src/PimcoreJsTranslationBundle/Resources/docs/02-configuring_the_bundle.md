Step 2: Configuring the Bundle
==============================

### A) Configure BazingaJsTranslationBundle

The following configurations are recommended for using the BazingaJsTranslationBundle in conjunction with
PimcoreJsTranslationBundle.

``` yaml
# app/config/config.yml

bazinga_js_translation:
    default_domain: 'pimcore'
    active_domains: ['pimcore']   # add more if you need to load other translation domains
    active_locales: ['en', 'de']  # all locales you need to translate your content in
```

### B) Register dynamic translation route

This step is also recommended and even mandatory if you want to use
[dynamic translations](04-dynamic_or_static_translations.md#dynamic-translations).

``` yaml
# app/config/routing.yml

bazinga_js_translation:
    resource: '@BazingaJsTranslationBundle/Resources/config/routing/routing.yml'
```

### C) Configure PimcoreJsTranslationBundle (optional)

Usually you don't need to change these configurations. The following configuration shows the default values and their
meaning.

``` yaml
# Default configuration for "PimcoreJsTranslationBundle"

pimcore_js_translation:

    # The source language from which the translations are made.
    default_locale:       en

    # The name of the translation domain used for Pimcore translations.
    domain_name:          pimcore
```

### Continue to the next step!
When you're done, continue by integrating with client application:
[Step 3: Integrating with client application](03-integrating_with_client_application.md).
