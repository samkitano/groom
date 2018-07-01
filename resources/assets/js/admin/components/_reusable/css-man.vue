<template>
    <div>
        <b-btn variant="primary"
               :disabled="working"
               v-b-modal="'addStyle'">Add CSS Rule
        </b-btn>

        <b-modal id="addStyle"
                 title="Add CSS"
                 ref="addStyle"
                 @cancel="onCancel"
                 @ok="emitRule">
            <b-form-group id="cssRuleGroup"
                          label="Rule"
                          label-for="cssRule">
                <b-form-select v-model="rule"
                               :options="options">
                    <template slot="first">
                        <option :value="null" disabled>-- Select a CSS rule --</option>
                    </template>
                </b-form-select>
            </b-form-group>

            <b-form-group id="cssValGroup"
                          label="Value"
                          label-for="cssVal"
                          v-if="rule">
                <b-form-input type="text"
                              placeholder="Value"
                              v-model="value"
                              @input="errorMsg = ''"
                              v-if="rule.type === 'text'"/>

                <b-form-select v-model="value"
                               v-if="rule.type === 'select'"
                               :options="rule.options"/>

                <b-form-input type="color"
                              placeholder="Value"
                              v-model="value"
                              v-if="rule.type === 'color'"/>

                <b-form-input type="number"
                              placeholder="Value"
                              v-model="value"
                              v-if="rule.type === 'number'"/>
            </b-form-group>

            <small class="text-danger" v-html="errorMsg"/>
        </b-modal>
    </div>
</template>

<script>
  import rules from '../../services/css-rules'

  import { find } from 'lodash'

  export default {
    beforeDestroy () {
      Bus.$off('openCssMan', this.openDialog)
    },

    beforeMount () {
      Bus.$on('openCssMan', this.openDialog)
    },

    computed: {
      options () {
        let opts = []

        for (let rule in this.rules) {
          opts.push({ text: this.rules[rule].label, value: this.rules[rule]})
        }

        return opts
      },

      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        errorMsg: null,
        rule: null,
        rules,
        value: null
      }
    },

    methods: {
      emitRule (evt) {
        evt.preventDefault()

        if (!this.value && !!this.rule) {
          this.errorMsg = 'You must provide a value for the rule'
        } else {
          this.$emit('add', { rule: this.rule.label, value: this.value.replace(/;$/, '') })
          this.$refs.addStyle.hide()
          this.errorMsg = null
          this.rule = null
          this.value = null
        }
      },

      onCancel () {
        this.rule = null
        this.value = null
      },

      openDialog (sets) {
        this.rule = find(rules, { label: sets.rule })
        this.$refs.addStyle.show()
        this.setValue(sets.value)
      },

      setValue (val) {
        setTimeout(() => {
          this.value = val
        }, 100)
      }
    },

    name: 'css-manager',

    watch: {
      rule () {
        if (this.rule === null) {
          return
        }

        this.errorMsg = ''

        switch (this.rule.type) {
          case 'color':
            this.value = '#000000'
            break
          case 'text':
            this.value = ''
            break
          case 'select':
            this.value = null
            break
          case 'number':
            this.value = 0
            break
          default:
            this.value = null
        }
      }
    }
  }
</script>
