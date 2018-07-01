<template>
    <b-card title="Settings"
            sub-title="App Settings">
        <!-- TODO -->
        <h3>This feature is not implemented quite yet.</h3>
    </b-card>
</template>

<script>
  export default {
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

    name: 'settings'
  }
</script>

<style lang="sass" scoped>

</style>
