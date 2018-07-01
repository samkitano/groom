<template>
    <div>
        <b-btn :id="uuid"
               :class="label ? 'my-4' : ''"
               variant="outline-info"
               :title="`Click for help`"
            ><span class="ti-info"
             /><span v-if="label" class="ml-1">{{ info.label }}</span
        ></b-btn>

        <b-popover :target="uuid"
                   placement="auto"
                   triggers="click"
                   :title="info.label">
            <div v-html="info.body"></div>
        </b-popover>
    </div>
</template>

<script>
  import * as fieldInfo from '../../services/popovers'

  export default {
    beforeMount () {
      this.fetchData()
    },

    computed: {
      uuidv4 () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
          let r = Math.random() * 16 | 0, v = c == 'x'
            ? r
            : (r & 0x3 | 0x8)
          return v.toString(16)
        })
      }
    },

    data () {
      return {
        info: {},
        uuid: ''
      }
    },

    methods: {
      fetchData () {
        if (fieldInfo[this.id]) {
          this.info = fieldInfo[this.id]
          this.uuid = this.uuidv4
        } else {
          throw new Error(`fieldInfo[${this.id}] is not defined`)
        }
      }
    },

    name: 'popover',

    props: {
      id: {
        required: true,
        type: String
      },
      label: {
        required: false,
        type: Boolean,
        default: false
      }
    }
  }
</script>

<style lang="sass">
    .popover-body
        color: darken(#80bdff, 10%)
    h3.popover-header
        color: #fff
        background-color: #80bdff
        &:before
            content: "\E697"
            font-family: themify
            margin-right: 1rem
</style>
