<template>
    <b-input-group prepend="Language"
                   class="w-400">
        <b-form-select class="lang-selector"
                       v-model="lang"
                       :options="$store.state.langs"
                       :disabled="disabled || working"/>
        <span slot="append" class="indicators" v-if="indicators.length > 0">
            <span v-for="(language, i) in $store.state.langs" :key="i">
                {{ language }} <span :class="allOrNone">{{ indicators[i] ? '&#x2611;' : '&#x2612;' }}</span>
            </span>
        </span>
    </b-input-group>
</template>

<script>
  export default {
    computed: {
      allOrNone () {
        if (!this.indicators.length) {
          return ''
        }

        if (this.valid !== null) {
          return this.valid
            ? 'text-success'
            : 'text-danger'
        }

        let initial

        for (let indicator in this.indicators) {
          if (initial === undefined) {
            initial = this.indicators[indicator]
            continue
          }

          let current = this.indicators[indicator]

          if (current !== initial) {
            return 'text-danger'
          }
        }

        return 'text-success'
      },

      working () {
        return this.$store.state.working
      }
    },

    created () {
      this.lang = this.value
    },

    data () {
      return {
        lang: ''
      }
    },

    name: 'lang-selector',

    props: {
      value: {
        required: true,
        type: String
      },
      disabled: {
        required: false,
        type: Boolean,
        default: false
      },
      indicators: {
        required: false,
        type: Array,
        default: () => []
      },
      valid: {
        required: false,
        default: null
      }
    },

    watch: {
      lang () {
        this.$emit('input', this.lang)
      }
    }
  }
</script>

<style lang="sass" scoped>
    .lang-selector
        max-width: 75px

    .indicators
        display: flex
        justify-content: center
        align-items: center
        padding: 0 .5rem
        border-radius: 0 3px 3px 0
        background-color: #e9ecef
        border: 1px solid #ced4da
        color: #495057

        span
            margin: 0 .25rem
</style>