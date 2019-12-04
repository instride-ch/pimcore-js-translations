<template>
  <component
    :is="tag"
    :inner-html.prop="id | trans(number, params, domain, locale)"
  />
</template>

<script>
export default {
  name: 'AppTranslator',

  filters: {
    trans(id, number, parameters, domain, locale) {
      if (!id) {
        return '';
      }

      if (Number.isFinite(number)) {
        let params = parameters;

        if (Object.keys(params).length) {
          params = { '%count%': number };
        }

        return Translator.transChoice(id, number, params, domain, locale);
      }

      return Translator.trans(id, parameters, domain, locale);
    },
  },

  props: {
    id: {
      required: true,
      type: String,
    },

    number: {
      type: Number,
      default: Infinity,
    },

    params: {
      type: Object,
      default: () => {},
    },

    domain: {
      type: String,
      default: 'pimcore',
    },

    locale: {
      type: String,
      default: null,
    },

    tag: {
      type: String,
      default: 'p',
    },
  },
};
</script>
