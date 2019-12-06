Pluralization
=============

This is probably one of the best features provided by this bundle! It allows you to use pluralization exactly like you
would do using the Symfony Translator component.

First make a translation in Pimcore's interface formatted as follows:

``` text
apples: "{0} There is no apple|{1} There is one apple|]1,19] There are %count% apples|[20,Inf] There are many apples"
```

Then translating it with the `Translator.transChoice()` method will output the following:

``` js
Translator.transChoice('apples', 0, { 'count' : 0 });
// will return "There is no apple"

Translator.transChoice('apples', 1, { 'count' : 1 });
// will return "There is one apple"

Translator.transChoice('apples', 2, { 'count' : 2 });
// will return "There are 2 apples"

Translator.transChoice('apples', 10, { 'count' : 10 });
// will return "There are 10 apples"

Translator.transChoice('apples', 19, { 'count' : 19 });
// will return "There are 19 apples"

Translator.transChoice('apples', 20, { 'count' : 20 });
// will return "There are many apples"

Translator.transChoice('apples', 100, { 'count' : 100 });
// will return "There are many apples"
```

For more information, read the official documentation about Symfony
[pluralization](https://symfony.com/doc/current/translation.html#pluralization).
