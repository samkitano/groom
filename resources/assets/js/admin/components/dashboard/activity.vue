<template>
    <b-card title="Activity"
            sub-title="Recent user activity">
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

    name: 'activity'
  }
</script>

<style lang="sass" scoped>

</style>
