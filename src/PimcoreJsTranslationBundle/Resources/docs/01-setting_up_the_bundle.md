Step 1: Setting up the Bundle
=============================

### A) Download PimcoreJsTranslationBundle

To download PimcoreJsTranslationBundle run the following command.

``` bash
$ php composer.phar require w-vision/pimcore-js-translation-bundle
```

### B) Enable and install PimcoreJsTranslationBundle

First enable and then install the bundle in Pimcore. You can either run the CLI commands for that
or also use the Pimcore bundle manager.

``` bash
$ php bin/console pimcore:bundle:enable PimcoreJsTranslationBundle
```

**Important:** Don't forget to clear the cache and reload the Pimcore interface after you've done that.

### Continue to the next step!
When you're done, continue by configuring the bundle appropriately:
[Step 2: Configuring the bundle](02-configuring_the_bundle.md).
