<template>
    <b-input-group prepend="Page"
                   class="mb-4">
        <b-form-select v-model="selfSelected"
                       :disabled="working"
                       :options="pages"/>
        <help id="modulePage" slot="append"/>
    </b-input-group>
</template>

<script>
  import help from '../_reusable/popover'
  import pagesApi from '../../services/api/pagesApi'

  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      help
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    created () {
      this.selfSelected = this.value
    },

    data () {
      return {
        selfSelected: null,
        pages: []
      }
    },

    methods: {
      fetchData () {
        pagesApi.list()
          .then((r) => {
            this.pages = r
          })
      }
    },

    name: 'page-selector',

    props: {
      selected: {
        required: false,
        type: Number,
        default: null
      },
      value: {
        required: true,
      }
    },

    watch: {
      selfSelected (v) {
        this.$emit('input', v)
      }
    }
  }
</script>
