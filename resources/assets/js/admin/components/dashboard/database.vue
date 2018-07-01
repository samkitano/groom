<template>
    <b-card title="Database"
            sub-title="Database Operations">
        <b-btn class="btn btn-danger btn-sm card-link"
               @click="execute('migrate')"
               :disabled="working"
        >Reset Database</b-btn>

        <wait-msg :show="working"/>
    </b-card>
</template>

<script>
  import waitMsg from '../_reusable/wait-msg'

  export default {
    components: {
      waitMsg
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    methods: {
      execute (command) {
        this.$emit('execute', command)
      }
    },

    name: 'database'
  }
</script>

<style lang="sass" scoped>

</style>
