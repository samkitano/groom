<template>
    <article class="admin-media">
        <collapse-transition>
            <div v-if="$store.state.loaded">
                <b-row class="mb-4"
                       v-if="totalRows > 5">
                    <b-col md="6" class="my-1">
                        <b-form-group horizontal
                                      label="Filter"
                                      class="mb-0">
                            <b-input-group>
                                <b-form-input v-model="filter"
                                              placeholder="Type to Search" />
                                <b-input-group-append>
                                    <b-btn :disabled="!filter"
                                           @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col md="6" class="my-1">
                        <b-form-group horizontal
                                      label="Per page"
                                      class="mb-0">
                            <b-form-select :options="pageOptions"
                                           v-model="perPage" />
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-table striped
                         hover
                         :items="media"
                         :fields="fields"
                         :current-page="currentPage"
                         :per-page="perPage"
                         :filter="filter"
                         :sort-by.sync="sortBy"
                         :sort-desc.sync="sortDesc"
                         @filtered="onFiltered"
                >
                    <template slot="name" slot-scope="row">
                        <div class="flex flex-column" v-if="row.item.type === 'image'">
                            <img :src="row.item.thumb"
                                 :alt="row.item.name"
                                 v-if="row.item.thumb">
                            <img height="48px"
                                 :src="row.item.url"
                                 :alt="row.item.name"
                                 v-else>
                        </div>
                    </template>

                    <template slot="actions" slot-scope="row">
                        <b-btn title="Delete"
                               size="sm"
                               variant="outline-danger"
                               @click.stop="deleteMedia(row.item)"><span class="ti-trash"/></b-btn>

                        <b-btn title="Edit"
                               size="sm"
                               variant="outline-primary"
                               :to="`/admin/media/${row.item.id}`"
                        ><span class="ti-pencil-alt"></span></b-btn>
                    </template>
                </b-table>

                <b-row class="mb-4 paginate"
                       v-if="totalRows > 5">

                    <b-pagination :total-rows="totalRows"
                              :per-page="perPage"
                              v-model="currentPage"
                              v-if="$store.state.loaded"/>
                </b-row>
            </div>
        </collapse-transition>
    </article>
</template>

<script>
  import mediaApi from '../../services/api/mediaApi'

  import { mapActions } from 'vuex'
  import { CollapseTransition } from 'vue2-transitions'
  import { alertConfirm } from '../../services/notifications'

  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      CollapseTransition
    },

    // computed: {
    //   sortOptions () {
    //     return this.fields
    //       .filter(f => f.sortable)
    //       .map(f => { return { text: f.label, value: f.key } })
    //   }
    // },

    data () {
      return {
        fields: [
          { key: 'name', label: 'Thumb', sortable: true },
          { key: 'type', label: 'Type', sortable: true },
          { key: 'size', label: 'Size', sortable: false },
          { key: 'mime', label: 'Mime', sortable: false },
          { key: 'actions', label: 'Actions', sortable: false }
        ],
        filter: null,
        currentPage: 1,
        media: [],
        perPage: 5,
        totalRows: 0,
        pageOptions: [ 5, 10, 15 ],
        sortBy: null,
        sortDesc: false
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'unSetLoaded', 'setCount']),

      deleteMedia (item) {
        alertConfirm('Are you sure you don\'t need this file anymore?')
          .then(go => {
            if (!go) {
              return false
            }

            this.unSetLoaded()

            mediaApi.delete(item.path)
              .then(() => { this.fetchData() })
          })
      },

      fetchData () {
        mediaApi.index()
          .then(r => {
            this.media = r
            this.totalRows = this.media.length
          })
          .finally(() => {
            this.setLoaded()
            this.setCount(this.totalRows)
          })
      },

      onFiltered (filteredItems) {
        this.totalRows = filteredItems.length
        this.currentPage = 1
      }
    },

    name: 'media-index'
  }
</script>

<style lang="sass" scoped>
    .paginate
        display: flex
        justify-content: center

    .flex
        display: flex
        justify-content: center
        align-items: center
</style>
