<template>
    <article class="admin-media">
        <collapse-transition>
            <b-card border-variant="info"
                    v-if="$store.state.loaded"
                    :header="header">
                <b-card-body>
                    <b-img :src="medium.url" fluid alt="medium.name"/>
                </b-card-body>

                <h3 class="card-text text-center" v-if="medium.type === 'image'">
                    {{ medium.width }} x {{ medium.height }}
                </h3>

                <b-list-group flush>
                    <b-list-group-item v-for="(key, i) in medium"
                                       :key="i"
                                       v-if="typeof key === 'string' || typeof key === 'number'"
                    >
                        <strong>{{ formatKey(i) }}</strong> <span>{{ key }}</span>
                    </b-list-group-item>

                    <b-list-group-item v-else>
                        <p><strong>{{ formatKey(i) }}</strong></p>
                        <ul>
                            <li v-for="(k, ii) in key">
                                <strong>{{ formatKey(ii) }}</strong> <span>{{ k }}</span>
                            </li>
                        </ul>
                    </b-list-group-item>
                </b-list-group>
            </b-card>
        </collapse-transition>
    </article>
</template>

<script>
  import mediaApi from '../../services/api/mediaApi'

  import { mapActions } from 'vuex'
  import { capitalize, startCase } from 'lodash'
  import { CollapseTransition } from 'vue2-transitions'
  import { alertConfirm, alertSuccess } from '../../services/notifications'

  export default {
    beforeDestroy () {
      Bus.$off('delete', this.deleteMedia)
    },

    beforeMount () {
      this.fetchData()
      Bus.$on('delete', this.deleteMedia)
    },

    components: {
      CollapseTransition
    },

    computed: {
      header () {
        let common = this.medium.type
        let aditional = common === 'image'
          ? ` ${this.medium.width} x ${this.medium.height}`
          : ''

        return capitalize(`${common}${aditional}`)
      }
    },

    data () {
      return {
        medium: {}
      }
    },

    methods: {
      ...mapActions(['setLoaded']),

      deleteMedia () {
        alertConfirm('Are you sure you don\'t need this file anymore?')
          .then(go => {
            if (!go) {
              return false
            }

            mediaApi.delete(this.medium.id)
              .then(() => {
                alertSuccess('DONE!', 'File deleted!')
                  .then(() => {
                    this.$router.push({ path: '/admin/media' })
                  })
              })
          })
      },

      fetchData () {
        mediaApi.get(this.$route.params.id)
          .then(r => { this.medium = r })
          .finally(() => { this.setLoaded() })
      },

      formatKey: (val) => startCase(val)
    },

    name: 'edit-media'
  }
</script>
