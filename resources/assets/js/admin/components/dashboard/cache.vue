<template>
    <b-card title="Cache"
            sub-title="Please be careful!">
        <b-btn class="btn btn-warning btn-sm card-link"
               title="Cache existing routes"
               :disabled="working"
               @click="execute('routeCache')">Cache Routes</b-btn>

        <b-btn class="btn btn-primary btn-sm card-link"
               title="Clear App Cache"
               :disabled="working"
               @click="execute('cacheClear')">Clear App</b-btn>

        <b-btn class="btn btn-primary btn-sm card-link"
               title="Clear Views Cache"
               :disabled="working"
               @click="execute('viewClear')">Clear Views</b-btn>

        <b-btn class="btn btn-primary btn-sm card-link"
               title="Clear Cached Routes"
               :disabled="working"
               @click="execute('routeClear')">Clear Routes</b-btn>

        <b-btn class="btn btn-primary btn-sm card-link"
               title="Rebuild Thumbnails"
               :disabled="working"
               @click="execute('rebuildThumbs')">Thumbs</b-btn>

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
      execute(command) {
        this.$emit('execute', command)
      }
    },

    name: 'cache'
  }
</script>

<style lang="sass" scoped>

</style>
