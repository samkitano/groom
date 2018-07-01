<template>
    <div>
        <div class="toolbar-container" v-if="toolbar === 'crud'">
            <b-btn title="Back To Previous Page"
                   variant="outline-success"
                   size="lg"
                   :disbled="$router.history.length === 1 || working"
                   @click="$router.go(-1)"><span class="ti-arrow-left"/></b-btn>

            <b-btn title="Index"
                   exact
                   size="lg"
                   :variant="$route.meta.crud === 0 ? 'primary' : 'outline-primary'"
                   :to="$route.meta.parent"
                   :disabled="$route.meta.crud === 0 || working"><span class="ti-menu-alt"/></b-btn>

            <b-btn title="Create"
                   exact
                   size="lg"
                   :variant="$route.meta.crud === 1 ? 'primary' : 'outline-primary'"
                   :to="`${$route.meta.parent}/create`"
                   :disabled="$route.meta.crud === 1 || working"><span class="ti-plus"/></b-btn>

            <b-btn title="Save"
                   size="lg"
                   variant="outline-success"
                   :disabled="!$store.state.canSaveBtn || working"
                   @click="emitOp('save')"><span class="ti-save"/></b-btn>

            <b-btn title="Delete"
                   size="lg"
                   variant="outline-danger"
                   :disabled="$route.meta.crud !== 2 || working"
                   @click="emitOp('delete')"><span class="ti-trash"/></b-btn>
        </div>

        <div class="toolbar-container" v-if="toolbar === 'dashboard'">
            <b-btn :variant="showView === 'stats' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Stats"
                   :disabled="working"
                   @click="emitShow('stats')"
            ><span class="ti-stats-up"/></b-btn>

            <b-btn :variant="showView === 'settings' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Settings"
                   :disabled="working"
                   @click="emitShow('settings')"
            ><span class="ti-settings"/></b-btn>

            <b-btn :variant="showView === 'database' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Settings"
                   :disabled="working"
                   @click="emitShow('database')"
            ><span class="ti-server"/></b-btn>

            <b-btn :variant="showView === 'cache' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Cache"
                   :disabled="working"
                   @click="emitShow('cache')"
            ><span class="ti-save-alt"/></b-btn>

            <b-btn :variant="showView === 'activity' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Activity"
                   :disabled="working"
                   @click="emitShow('activity')"
            ><span class="ti-user"/></b-btn>

            <b-btn :variant="showView === 'logs' ? 'info' : 'outline-info'"
                   size="lg"
                   title="Logs"
                   :disabled="working"
                   @click="emitShow('logs')"
            ><span class="ti-support"/></b-btn>
        </div>

        <div class="toolbar-container" v-if="toolbar === 'profile'">
            <b-btn :variant="showView === 'chgName' ? 'primary' : 'outline-primary'"
                   size="lg"
                   title="Change Name"
                   :disabled="working"
                   @click="emitShow('chgName')"
            ><span class="ti-user"/></b-btn>

            <b-btn :variant="showView === 'chgPw' ? 'primary' : 'outline-primary'"
                   size="lg"
                   title="Change Password"
                   :disabled="working"
                   @click="emitShow('chgPw')"
            ><span class="ti-key"/></b-btn>

            <b-btn :variant="showView === 'chgEmail' ? 'primary' : 'outline-primary'"
                   size="lg"
                   title="Change Email"
                   :disabled="working"
                   @click="emitShow('chgEmail')"
            ><span class="ti-email"/></b-btn>

            <b-btn title="Save"
                   size="lg"
                   variant="outline-success"
                   :disabled="!$store.state.canSaveBtn || working"
                   @click="emitOp('save')"><span class="ti-save"/></b-btn>
        </div>
    </div>
</template>

<script>
  const toolbars = ['dashboard', 'crud', 'profile']

  export default {
    beforeDestroy () {
      Bus.$off('setActiveTBtn', this.setActiveTBtn)
    },

    beforeMount () {
      Bus.$on('setActiveTBtn', this.setActiveTBtn)
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        saveDisabled: true,
        toolbar: toolbars[this.$route.meta.toolbar] || null,
        showView: 'stats'
      }
    },

    methods: {
      emitOp (op) {
        Bus.$emit(op)
      },

      emitShow (op) {
        Bus.$emit('show', op)
      },

      setActiveTBtn (btn) {
        this.showView = btn
      },
    },

    name: 'tool-bar',

    watch: {
      $route (r) {
        this.toolbar = toolbars[r.meta.toolbar] || null
      }
    }
  }
</script>

<style lang="sass">
    .toolbar-container
        display: flex
        flex-direction: column
        padding: 0 6px

        .btn
            margin-bottom: 1rem
</style>