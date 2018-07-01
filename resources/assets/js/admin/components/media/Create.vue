<template>
    <article class="admin-media">
        <collapse-transition>
            <div v-if="$store.state.loaded">
                <vue-dropzone id="drop1" :options="dropOptions"/>
            </div>
        </collapse-transition>
    </article>
</template>

<script>
  import vueDropzone from "vue2-dropzone"
  import mediaApi from '../../services/api/mediaApi'

  import 'vue2-dropzone/dist/vue2Dropzone.min.css'

  import { mapActions } from 'vuex'
  import { CollapseTransition } from 'vue2-transitions'

  export default {
    beforeMount () {
      this.fetchData()
    },

    data () {
      return {
        dropOptions: {
          url: '',
          headers: {
            'X-CSRF-TOKEN': ''
          },
          maxFilesize: 2,
          paramName: 'file',
          parallelUploads: 1,
          thumbnailWidth: 150,
          addRemoveLinks: true,
          dictDefaultMessage: "<span class='ti-cloud-up'/> <span class='msg'>Drag files here, or click to upload</span>"
        }
      }
    },

    components: {
      vueDropzone,
      CollapseTransition
    },

    methods: {
      ...mapActions(['setLoaded']),

      fetchData () {
        let token = document.head.querySelector('meta[name="csrf-token"]')
        this.dropOptions.headers['X-CSRF-TOKEN'] = token.content

        mediaApi.endpoint()
          .then(r => this.dropOptions.url = r)
          .finally(() => {
            this.setLoaded()
          })
      }
    },

    name: 'uploads'
  }
</script>

<style lang="sass">
    .dropzone
        .dz-message
            font-size: 2rem !important
            span.msg
                font-family: 'hack', monospace !important
</style>
