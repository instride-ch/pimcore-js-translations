Step 3: Integrating with Client Application
===========================================

### A) Define Language

Define the language you want your content to be translated in, by adding a `lang` attribute to the `html` tag:

``` html
<html lang="{{ app.request.locale|slice(0, 2) }}">
```

### B) Load JavaScript Translator Library

To use the `Translator` object in your JS files you can either load it globally or `require` / `import` it as a module.

- To load it globally add the following line to your template. If you want to use
[dynamic translations](04-dynamic_or_static_translations.md#dynamic-translations) you have to use this approach.

``` html
<script src="{{ asset('bundles/bazingajstranslation/js/translator.min.js') }}"></script>
```

- To load it as a module you must be using a module bundler (e.g. `webpack`) and it is recommended that you install the
translator via `npm`. Then in your JS file you can do:

``` js
// ES2015
import Translator from 'bazinga-translator';

// ES5
var Translator = require('bazinga-translator');
```

**Important:** The second way of adding the `Translator` can only be used with
[static translations](04-dynamic_or_static_translations.md#static-translations).

### C) Load Translations

Loading translations is a matter of adding a new `script` tag as follows:

``` html
<script src="{{ url('bazinga_jstranslation_js', { domain: 'pimcore' }) }}"></script>
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
