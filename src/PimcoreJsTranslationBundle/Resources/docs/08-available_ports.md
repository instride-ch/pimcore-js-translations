Available Ports
===============

Ports are tiny wrappers around the `Translator` library, which can be used in other JavaScript frameworks. The following
ports are currently available.

## Vue.js

**Usage**

``` js
import Vue from 'vue';
import AppTranslator from './AppTranslator.vue';

Vue.use(AppTranslator);
```

``` vue
<template>
    <div>
        <app-translator
            id="app.my_translation.key"
            :number="3"
            :params="{
                'my-param': 'my-value',
                count: 3,
            }"
        />
    </div>
</template>
```

The `AppTranslator.vue` component can be downloaded
[here](https://github.com/w-vision/PimcoreJsTranslationBundle/blob/master/ports/vue/AppTranslator.vue).
