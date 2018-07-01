import Vue from 'vue'

Vue.mixin({
  methods: {
    validateHasOnlyLettersAndDots (str) {
      return !/[^a-zA-Z.]/.test(str)
    },

    validateHasOnlyLettersAndNumbers (str) {
      return !/[^a-zA-Z0-9]/.test(str)
    },

    validateNotEmptyStr (str) {
      return str !== ''
    },

    validateAllOrNone (data, fieldName) {
      let first

      for (let item in data) {
        if (data.hasOwnProperty(item)) {
          if (first === undefined) {
            first = data[item] && data[item].length > 0
            continue
          }

          let current = data[item] && data[item].length > 0

          if (first !== current) {
            return `${fieldName} must be either filled or empty in all lnguages`
          }
        }
      }

      return true
    }
  }
})
