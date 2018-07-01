<template>
    <section class="admin-users" v-if="$store.state.loaded">
        <!-- TODO -->
        <h3>This feature is not implemented quite yet.</h3>
    </section>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    beforeMount () {
      this.fetchData()
    },

    methods: {
      ...mapActions(['setLoaded']),

      fetchData () {
        this.setLoaded()
      }
    },

    name: 'users-create'
  }
</script>

<style lang="sass" scoped>

</style>
