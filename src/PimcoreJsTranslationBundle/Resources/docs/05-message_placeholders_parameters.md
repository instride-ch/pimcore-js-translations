Message Placeholders / Parameters
=================================

The `Translator.trans()` method accepts a second argument that takes an array of parameters.

``` js
Translator.trans('key', { foo : 'bar' });
// will replace each "%foo%" in the message by "bar".
```

The `Translator.transChoice()` method accepts this array of parameters as third argument.

``` js
Translator.transChoice('key', 123, { foo : 'bar' });
// will replace each "%foo%" in the message by "bar".
```

## Example

Consider the following translation.

``` text
placeholder: "Hello %username%, how are you?"
```

You can do:

``` js
Translator.trans('placeholder');
// will return 'Hello %username%, how are you?'

Translator.trans('placeholder', { username : 'John' });
// will return 'Hello John, how are you?'
```

Read the official documentation about Symfony
[message placeholders](https://symfony.com/doc/current/translation.html#message-format).
