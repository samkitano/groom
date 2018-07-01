<template>
    <section class="admin-dashboard">
        <div class="panels">
            <collapse-transition group>
                <stats key="stats"
                       v-if="showView === 'stats'"/>

                <settings key="settings"
                          v-if="showView === 'settings'"
                          @execute="execute"/>

                <db key="database"
                    v-if="showView === 'database'"
                    @execute="execute"/>

                <cache key="cache"
                    v-if="showView === 'cache'"
                    @execute="execute"/>

                <activity key="activity"
                          v-if="showView === 'activity'"/>

                <log-manager key="logs"
                             @count="setCounter"
                             v-if="showView === 'logs'"/>
            </collapse-transition>
        </div>
    </section>
</template>

<script>
  import db from './database'
  import cache from './cache'
  import stats from './stats'
  import settings from './settings'
  import activity from './activity'
  import logManager from './log-man'
  import utilApi from '../../services/api/utilApi'

  import { mapActions } from 'vuex'
  import { CollapseTransition } from 'vue2-transitions'
  import { alertConfirm, alertSuccess } from '../../services/notifications'

  export default {
    beforeDestroy () {
      Bus.$off('show', this.show)
    },

    beforeMount () {
      Bus.$on('show', this.show)
      this.fetchData()
    },

    components: {
      CollapseTransition,
      logManager,
      stats,
      settings,
      db,
      cache,
      activity
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        commands: {
          routeCache: {
            text: 'Cache Application Routes?',
            command: 'route:cache'
          },
          cacheClear: {
            text: 'Clear Application Cache?',
            command: 'cache:clear'
          },
          viewClear: {
            text: 'Clear Cached Views?',
            command: 'view:clear'
          },
          rebuildThumbs: {
            text: 'Rebuild Thumbnails Tree?',
            command: 'thumbs:rebuild'
          },
          routeClear: {
            text: 'Clear Cached Routes?',
            command: 'route:clear'
          },
          migrate: {
            text: '<span class="text-danger">CAUTION!!!</span><br> This will RESET the database to its original state. Proceed?',
            command: 'migrate:refresh --seed'
          }
        },
        payload: {
          _method: 'PATCH',
          command: ''
        },
        showView: 'stats'
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'unSetLoaded', 'setCount', 'setEditingName']),

      execute (command) {
        this.payload.command = this.commands[command].command

        if (!this.$store.state.loaded) {
          return false
        }

        alertConfirm(this.commands[command].text)
          .then(go => {
            if (!go) {
              return false
            }

            this.unSetLoaded()

            utilApi.execArtisanCommand(this.payload)
              .then(o => {
                alertSuccess('DONE', o)
              })
              .finally(() => {
                this.setLoaded()
              })
          })
      },

      fetchData () {
        this.setLoaded()
      },

      setCounter (c) {
        this.setCount(c)
      },

      show (view) {
        if (this.showView === view) {
          this.showView = ''
        } else {
          if (this.showView === '') {
            this.showView = view

          } else {
            this.showView = ''
            setTimeout(() => {
              this.showView = view
            }, 300)
          }
        }
      }
    },

    name: 'Dashboard',

    watch: {
      showView () {
        Bus.$emit('setActiveTBtn', this.showView)
        this.setEditingName(this.showView)
      }
    }
  }
</script>

<style lang="sass" scoped>
    .admin-dashboard
        display: flex
        flex-direction: column

    .view-selector
        flex-shrink: 1
        display: flex
        flex-direction: column
        padding: 0 4px 4px 4px
        margin-left: -2rem

        .btn
            margin-bottom: 1rem

    .panels
        width: 100%
        display: block
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.12), 0 2px 4px 0 rgba(0, 0, 0, 0.08)

    a
        margin-top: 1rem

</style>
