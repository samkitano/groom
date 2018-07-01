<template>
    <div class="log-manager">
        <b-card key="logs"
                title="Logs"
                sub-title="System Logs">
            <div v-if="!logs && !$store.state.loaded">
                <h4 class="text-muted">Fetching Logs. Please wait...</h4>
            </div>

            <!-- Log Selection -->
            <b-form-select v-model="selected"
                           :options="logs"
                           :disabled="working"
                           v-if="logs && logs.length > 0"
                           class="my-4">
                <template slot="first">
                    <option :value="null">-- Select a Log --</option>
                </template>
            </b-form-select>

            <div v-if="logs && logs.length === 0 && $store.state.loaded">
                <h3 class="text-muted">No logs found.</h3>
            </div>

            <div class="mb-4">

                <!-- Archiving -->
                <b-dropdown id="ddown1"
                            size="sm"
                            variant="primary"
                            :disabled="working || !logs.length"
                            title="Archive">
                    <template slot="button-content">
                        <span class="ti-zip"/>
                    </template>

                    <b-dropdown-item-button @click="archiveAll">Archive All</b-dropdown-item-button>

                    <b-dropdown-item-button @click="archiveSelected"
                                            :disabled="!selected">Archive Selected</b-dropdown-item-button>
                </b-dropdown>

                <!--Downloads-->
                <b-dropdown id="ddown2"
                            size="sm"
                            variant="primary"
                            :disabled="working || (!logs.length && !master)"
                            title="Download">
                    <template slot="button-content">
                        <span class="ti-download"/>
                    </template>

                    <b-dropdown-header>Raw Logs</b-dropdown-header>

                    <b-dropdown-item-button :disabled="!selected || working"
                                            @click="downloadSelected">Download Selected</b-dropdown-item-button>

                    <b-dropdown-divider></b-dropdown-divider>

                    <b-dropdown-header>Archived Logs</b-dropdown-header>

                    <b-dropdown-item-button :disabled="!master || working"
                                            @click="downloadMaster">Download Master</b-dropdown-item-button>

                    <b-dropdown-item-button v-for="(archive, i) in archived"
                                            :disabled="working"
                                            :key="i"
                                            @click="downloadArchived(archive)">Download "{{ archive }}"</b-dropdown-item-button>
                </b-dropdown>

                <!--Deletions-->
                <b-dropdown id="ddown3"
                            size="sm"
                            variant="danger"
                            :disabled="working || (!logs.length && !master)"
                            title="Delete"
                            class="m-md-2">
                    <template slot="button-content">
                        <span class="ti-trash"/>
                    </template>

                    <b-dropdown-header>Raw Logs</b-dropdown-header>

                    <b-dropdown-item-button :disabled="!selected || working"
                                            @click="deleteSelected">Delete Selected</b-dropdown-item-button>

                    <b-dropdown-item-button :disabled="working || !logs.length"
                                            @click="deleteAllLogs">Delete All</b-dropdown-item-button>

                    <b-dropdown-divider></b-dropdown-divider>

                    <b-dropdown-header>Archived Logs</b-dropdown-header>

                    <b-dropdown-item-button :disabled="!master || working"
                                            @click="deleteMaster">Delete Master</b-dropdown-item-button>

                    <b-dropdown-item-button :disabled="archived.length === 0 || working"
                                            @click="deleteAllArchived">Delete All</b-dropdown-item-button>

                    <b-dropdown-item-button v-for="(archive, i) in archived"
                                            :key="i"
                                            :disabled="working"
                                            @click="deleteArchived(archive)">Delete "{{ archive }}"</b-dropdown-item-button>
                </b-dropdown>
            </div>

            <div class="my-4">
                <slide-y-up-transition>
                    <log-viewer v-if="selected"
                                :log-name="selected"/>
                </slide-y-up-transition>
            </div>
        </b-card>
    </div>
</template>

<script>
  import logViewer from '../_reusable/log'
  import logsApi from '../../services/api/logsApi'
  import downloadsApi from '../../services/api/downloadsApi'
  import logArchivesApi from '../../services/api/logArchivesApi'

  import { mapActions } from 'vuex'
  import { SlideYUpTransition } from 'vue2-transitions'
  import { alertConfirm, alertSuccess } from '../../services/notifications'

  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      logViewer,
      SlideYUpTransition
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        archived: [],
        currentPage: 1,
        fields: [
          { key: 'datetime', label: 'DT', sortable: true },
          { key: 'env', label: 'Env', sortable: true },
          { key: 'level', label: 'Lvl', sortable: true },
          { key: 'error', label: 'Error', sortable: true, class: 'wrap' },
          { key: 'actions', label: 'Actions', sortable: false }
        ],
        filter: null,
        logs: null,
        log: null,
        master: false,
        modalInfo: null,
        modalTitle: null,
        pageOptions: [ 5, 10, 15 ],
        perPage: 5,
        selected: null,
        totalRows: 0
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'unSetLoaded']),

      archiveAll () {
        logArchivesApi.master()
          .then(() => {
            this.master = true
            alertSuccess('ARCHIVED', 'All existing Logs were successfully archived')
          })
      },

      archiveSelected () {
        logArchivesApi.archive(this.selected)
          .then(() => {
            alertSuccess('ARCHIVED', `Log ${this.selected} successfully archived.`)
          })
          .finally(() => {
            this.fetchArchives()
          })
      },

      deleteAllLogs () {
        alertConfirm(`DELETE ALL LOGS? REALLY?`)
          .then(go => {
            if (!go) {
              return false
            }

            logsApi.deleteAll()
              .then(() => {
                this.logs = []
              })
          })
      },

      deleteMaster () {
        alertConfirm('DELETE MASTER LOGS ARCHIVE?')
          .then(go => {
            if (!go) {
              return false
            }

            logArchivesApi.deleteMaster()
              .then(() => {
                this.master = false
                alertSuccess('DELETED!', 'Master logs archive was successfully erased')
              })
          })
      },

      deleteAllArchived () {
        alertConfirm('DELETE ALL ARCHIVED LOGS', 'Are you sure?')
          .then(go => {
            if (!go) {
              return false
            }

            logArchivesApi.deleteAll()
              .then(() => {
                alertSuccess('DELETED', 'All archived logs were deleted')
              })
              .finally(() => {
                this.fetchArchives()
              })
          })
      },

      deleteArchived (name) {
        alertConfirm(`DELETE ARCHIVE ${name}?`)
          .then(go => {
            if (!go) {
              return false
            }

            logArchivesApi.delete(name)
              .then(() => {
                alertSuccess('DELETED!', `Archive ${name} was successfully erased`)
              })
              .finally(() => {
                this.fetchArchives()
              })
          })
      },

      deleteSelected () {
        alertConfirm(`Delete Log ${this.selected}?`)
          .then(go => {
            if (!go) {
              return false
            }

            logsApi.delete(this.logName)
              .then(() => {
                this.log = null
                this.fetchData()
              })
          })
      },

      downloadMaster () {
        this.unSetLoaded()

        downloadsApi.getMaster()
          .then(() => {
            this.master = true
          })
          .finally(() => {
            this.setLoaded()
          })
      },

      downloadArchived (name) {
        this.unSetLoaded()

        downloadsApi.getArchived(name)
          .finally(() => {
            this.setLoaded()
          })
      },

      downloadSelected () {
        this.unSetLoaded()

        downloadsApi.getRaw(this.selected)
          .finally(() => {
            this.setLoaded()
          })
      },

      fetchArchives () {
        logArchivesApi.index()
          .then(r => {
            this.archived = r
            logArchivesApi.masterExists()
              .then(r => {
                this.master = r
              })
          })
      },

      fetchData () {
        this.selected = null
        this.unSetLoaded()

        logsApi.index()
          .then(r => {
            this.logs = r
            this.fetchArchives()
          })
          .finally(() => {
            this.setLoaded()
          })

      }
    },

    name: 'logs-manager',

    watch: {
      selected (log) {
        if (log !== null) {
          this.log = this.logs[log]
        }
      }
    }
  }
</script>
