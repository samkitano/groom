<template>
    <article class="admin-modules">
        <b-card no-body class="mb-4"
                v-if="$store.state.loaded">
            <b-tabs card v-model="tabIndex">
                <b-tab no-body
                       v-for="(page, i) in pages"
                       :key="`page_${i}`"
                       :title="i">
                    <help id="modulesIndex" label/>

                    <draggable v-model="pages[i]"
                               v-if="i !== 'orphan'"
                               @end="onEnd(i)">
                        <transition-group>
                            <div class="my-4"
                                 v-for="module in page"
                                 :key="`module_${module.id}`">
                                <orderable-item
                                        :leftText="module.order"
                                        :middleText="module.name"
                                        :link="`/admin/modules/${module.id}`"
                                />
                            </div>
                        </transition-group>
                    </draggable>

                    <non-orderable-list v-if="i === 'orphan'"
                                        :modules="pages[i]"
                                        @deleted="fetchData"/>
                </b-tab>
            </b-tabs>
        </b-card>
    </article>
</template>

<script>
  import help from '../_reusable/popover'
  import modulesApi from '../../services/api/modulesApi'
  import draggable from '../../plugins/vuedraggable'
  import orderableItem from '../_reusable/orderable-item'
  import nonOrderableList from '../_reusable/non-orderable-list'

  import { mapActions } from 'vuex'
  import { sortBy, groupBy } from 'lodash'

  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      draggable,
      help,
      orderableItem,
      nonOrderableList
    },

    data () {
      return {
        lang: 'en',
        modules: [],
        pages: {},
        payload: {
          _method: 'PATCH',
          modules: []
        },
        tabIndex: 0
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'setCount', 'toggleAlert']),

      fetchData () {
        modulesApi.index()
          .then((r) => {
            this.modules = sortBy(r, ['order'])
            this.pages = groupBy(r, (c) => {
              if (c.page && c.page.hasOwnProperty('name')) {
                return c.page.name
              } else {
                return 'orphan'
              }
            })

            for (let item in this.pages) {
              this.pages[item] = sortBy(this.pages[item], ['order'])
            }

            this.setLoaded()
            this.setCount(this.modules.length)
          })
      },

      onEnd (page) {
        this.preparePayload(page)

        modulesApi.reorder(this.payload)
      },

      preparePayload (page) {
        this.payload.modules = []
        let modules = []

        if (page === undefined || !page) {
          for (let i in this.modules) {
            this.modules[i].order = parseInt(i) + 1
            modules.push({ id: this.modules[i].id, order: this.modules[i].order })
          }

          this.payload.modules = modules

          return
        }

        for (let i in this.pages[page]) {
          this.pages[page][i].order = parseInt(i) + 1
          modules.push({ id: this.pages[page][i].id, order: this.pages[page][i].order })
        }

        this.payload.modules = modules
      }
    },

    name: 'modules-index'
  }
</script>
