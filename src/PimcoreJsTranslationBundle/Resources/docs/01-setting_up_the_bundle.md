Step 1: Setting up the Bundle
=============================

### A) Download PimcoreJsTranslationBundle

To download PimcoreJsTranslationBundle run the following command.

``` bash
$ composer require instride/pimcore-js-translation
```

### B) Add to bundles.php

Add the following line to your `config/bundles.php` file:

``` php
<?php

return [
    // ...
    Instride\Bundle\PimcoreJsTranslationBundle\PimcoreJsTranslationBundle::class => ['all' => true],
    // ...
];
```

### Continue to the next step!
When you're done, continue by configuring the bundle appropriately:
[Step 2: Configuring the bundle](02-configuring_the_bundle.md).
