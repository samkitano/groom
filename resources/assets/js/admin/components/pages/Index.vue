<template>
    <section class="admin-pages">
        <collapse-transition>
            <b-table v-if="$store.state.loaded" striped hover :items="pages" :fields="fields">
                <template slot="actions" slot-scope="row">
                    <b-btn title="Delete"
                           size="sm"
                           variant="outline-danger"
                           :disabled="working"
                           @click.stop="deletePage(row.item)"><span class="ti-trash"/></b-btn>

                    <b-btn title="Edit"
                           size="sm"
                           variant="outline-primary"
                           :disabled="working"
                           :to="`/admin/pages/${row.item.id}`"
                    ><span class="ti-pencil-alt"></span></b-btn>
                </template>
            </b-table>
        </collapse-transition>
    </section>
</template>

<script>
  import pagesApi from '../../services/api/pagesApi'

  import { mapActions } from 'vuex'
  import { CollapseTransition } from 'vue2-transitions'
  import {
    noDelHomePage,
    alertConfirm,
    alertSuccess
  } from '../../services/notifications'

  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      CollapseTransition
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        fields: ['id', 'name', 'actions'],
        pages: []
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'setCount', 'unSetLoaded']),

      deletePage (item) {
        if (item.name === 'home') {
          noDelHomePage()
          return false
        }

        alertConfirm(`Are you sure you want to delete the page "${item.name}"?<br><br><span style="color:darkred">THIS ACTION IS IRREVERSIBLE</span>!`)
          .then((go) => {
            if (!go) {
              return false
            }

            this.unSetLoaded()

            pagesApi.delete(item.id)
              .then(() => {
                this.fetchData()
                alertSuccess('DONE', `Page "${item.name}" was deleted!`)
              })
          })
      },

      fetchData () {
        pagesApi.index()
          .then(r => { this.pages = r })
          .finally(() => {
            this.setLoaded()
            this.setCount(this.pages.length)
          })
      }
    },

    name: 'pages-index'
  }
</script>
