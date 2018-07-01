<template>
    <div class="non-orderable-container">
        <b-btn title="Delete All"
               variant="outline-danger"
               :disabled="working"
               class="my-2"
               @click.stop="deleteAllOrphans"
        >Delete All Orphans</b-btn>

        <b-table class="my-4"
                 striped
                 hover
                 :items="modules"
                 :fields="['id','name', 'actions'] ">
            <template slot="actions" slot-scope="row">
                <b-btn title="Delete"
                       size="sm"
                       variant="outline-danger"
                       @click.stop="deleteModule(row.item, row.index)"><span class="ti-trash"/></b-btn>

                <b-btn title="Edit"
                       size="sm"
                       variant="outline-primary"
                       :to="`/admin/modules/${row.item.id}`"
                ><span class="ti-pencil-alt"></span></b-btn>
            </template>
        </b-table>
    </div>
</template>

<script>
  import modulesApi from '../../services/api/modulesApi'

  import { alertConfirm, alertSuccess } from '../../services/notifications'

  export default {
    computed: {
      working () {
        return this.$store.state.working
      }
    },

    methods: {
      deleteAllOrphans () {
        alertConfirm(`Are you sure you don't need this modules anymore?<br><br><span style="color:darkred">THIS ACTION IS IRREVERSIBLE</span>!`)
          .then(go => {
            if (!go) {
              return false
            }

            let ids = this.getOrphanIds()

            modulesApi.deleteOrphans(ids)
              .then(() => {
                alertSuccess('KABOOM!', 'All orphan modules were deleted')
                  .then(() => {
                    this.$emit('deleted')
                  })
              })
          })
      },

      deleteModule (item, idx) {
        alertConfirm(`Are you sure you want to delete the module "${item.name}"?<br><br><span style="color:darkred">THIS ACTION IS IRREVERSIBLE</span>!`)
          .then(go => {
            if (!go) {
              return false
            }

            modulesApi.delete(item.id)
              .then(() => {
                this.modules.splice(idx, 1)
                alertSuccess('ZAPPED!', `Module "${item.name}" was deleted!`)
              })
          })
      },

      getOrphanIds () {
        let ids = []

        for (let m in this.modules) {
          ids.push(this.modules[m].id)
        }

        return ids
      }
    },

    name: 'non-orderable-list',

    props: {
      modules: {
        type: [Array, Object],
        required: true
      }
    }
  }
</script>
