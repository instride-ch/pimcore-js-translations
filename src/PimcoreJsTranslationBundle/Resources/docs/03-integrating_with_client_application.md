Step 3: Integrating with Client Application
===========================================

### A) Load Translations

By default, the bundle outputs the translations as JavaScript. You can change that behavior by adding a format parameter
to the `url` helper.

``` html
<script src="{{ url('pimcore_js_translations', {'format': 'json'}) }}"></script>
```

By default, only the locale in the current request is loaded. If you need to load more locales at once, you can define
another parameter in the `url` helper.

``` html
<script src="{{ url('pimcore_js_translations', {'locales': 'en,de,fr'}) }}"></script>
```

**Note:** Make sure to comma-separate the locales.

### B) Load JavaScript Translator Library

This bundle does **not** come with its own translator library. You can use whatever library you want for that.
In case you're not sure how to go about this, have a look at the [example usages](index.md#example-usages).

### C) Load Translations

Loading translations is a matter of adding a new `script` tag as follows:

``` html
<script src="{{ url('bazinga_jstranslation_js', {'domain': 'pimcore'}) }}"></script>
```

This will use the current `locale` and will return the translated messages found in each `pimcore.CURRENT_LOCALE.xlf`
file of your project.

In case you do not want to expose the entire translation domain to your frontend, you can manually add translations to
the translator collections. This simulates the way how the above script would add translations, but allows you to use
any other renderer (like `Twig` or `PHP`) to make translations accessible.

``` twig
<script>
/**
 * Adds a translation entry.
 *
 * @param {String} id         The message id
 * @param {String} message    The message to register for the given id
 * @param {String} [domain]   The domain for the message or null to use the default
 * @param {String} [locale]   The locale or null to use the default
 * @return {Object}           Translator
 * @api public
 */
Translator.add(
    'translation_key',
    '{{ 'translation_key'|trans }}',
    'messages',
    'en'
);
</script>
```

**Not enough?** Read more on that topic
[here](https://github.com/willdurand/BazingaJsTranslationBundle/blob/master/Resources/doc/index.md#load-translations).

That's the basic setup! For additional information and configuration check the
[Usage and Features](index.md#usage-and-features) section.
