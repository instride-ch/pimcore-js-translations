Step 2: Configuring the Bundle
==============================

### A) Configure PimcoreJsTranslationBundle

The following configurations are available.

``` yaml
# Default configuration for "PimcoreJsTranslationBundle"
pimcore_js_translation:

    # The fallback language for non-existent translations.
    locale_fallback:      en

    # The amount of seconds the translation content is cached.
    http_cache_time:      86400

    # Whether to output the JavaScript content minified or not.
    minify_output:        false
```

**Note:** You don't have to register the dynamic translation route, this is done automatically for you.

### Continue to the next step!
When you're done, continue by integrating with client application:
[Step 3: Integrating with client application](03-integrating_with_client_application.md).
