<template>
    <div v-if="$store.state.loaded">
        <hr>

        <div class="my-4 p-2">
            <h3 class="log-title">
                {{ logName }}
                <b-badge>[{{ log.length }} entries]</b-badge>
            </h3>
        </div>

        <div class="mb-4"
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
        </div>

        <b-table striped
                 hover
                 class="table-responsive table-body"
                 stacked="md"
                 v-if="log"
                 :current-page="currentPage"
                 :per-page="perPage"
                 :filter="filter"
                 :fields="fields"
                 :items="log.entries">
            <template slot="datetime" slot-scope="row">
                <span class="badge badge-info" v-html="onlyTime(row.item.datetime)"></span>
            </template>

            <template slot="env" slot-scope="row">
                <span>{{ row.item.env }}</span>
            </template>

            <template slot="level" slot-scope="row">
                <span :title="row.item.level" :class="errorLevel(row.item.level)"/>
            </template>

            <template slot="actions" slot-scope="row">
                <b-btn size="sm"
                       title="Show Raw Header"
                       v-b-modal.stackTrace
                       variant="outline-primary"
                       @click="modalInfo = row.item.raw_header; modalTitle = 'Raw Header'"
                ><span class="ti-credit-card"/></b-btn>

                <b-btn size="sm"
                       title="Show Stack Trace"
                       v-b-modal.stackTrace
                       variant="outline-primary"
                       @click="modalInfo = row.item.stack; modalTitle = 'Stack Trace'"
                ><span class="ti-more"/></b-btn>
            </template>
        </b-table>

        <div class="mb-4 paginate"
             v-if="totalRows > 5">

            <b-pagination :total-rows="totalRows"
                          :per-page="perPage"
                          v-model="currentPage"
                          v-if="$store.state.loaded"/>
        </div>

        <b-modal id="stackTrace"
                 size="lg"
                 @hide="resetModal"
                 :title="modalTitle"
                 ok-only>
            <pre class="wrap">
                {{ modalInfo }}
            </pre>
        </b-modal>
    </div>
</template>

<script>
  import logsApi from '../../services/api/logsApi'

  import { mapActions } from 'vuex'

  const errorLevels = { error: 'ti-alert text-danger' }

  export default {
    beforeMount () {
      this.fetchData()
    },

    data () {
      return {
        currentPage: 1,
        fields: [
          { key: 'datetime', label: 'DT', sortable: true },
          { key: 'env', label: 'Env', sortable: true },
          { key: 'level', label: 'Lvl', sortable: true },
          { key: 'error', label: 'Error', sortable: true, class: 'wrap' },
          { key: 'actions', label: 'Actions', sortable: false }
        ],
        filter: null,
        log: null,
        modalInfo: null,
        modalTitle: null,
        pageOptions: [ 5, 10, 15 ],
        perPage: 5,
        totalRows: 0
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'unSetLoaded']),

      errorLevel (level) {
        return errorLevels[level] || 'ti-info text-info'
      },

      fetchData () {
        this.unSetLoaded()

        logsApi.get(this.logName)
          .then(log => {
            this.log = log
            this.totalRows = log.length
            this.currentPage = 1
          })
          .finally(() => {
            this.setLoaded()
          })
      },

      onlyTime (date) {
        let exp = date.split(' ')
        return exp[1]
      },

      onFiltered (filteredItems) {
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },

      resetModal () {
        this.modalInfo = null
        this.modalTitle = null
      },
    },

    name: 'log-manager',

    props: {
      logName: {
        type: String,
        required: true
      }
    },

    watch: {
      logName (ln) {
        if (ln !== null) {
          this.fetchData()
        }
      }
    }
  }
</script>

<style lang="sass" scoped>
    .log-title
        display: flex
        align-items: center
        span
            margin-left: 1rem

    .paginate
        display: flex
        justify-content: center

    table
        font-size: .8rem
        font-family: 'hack', monospace
</style>
