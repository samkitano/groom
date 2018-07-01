<template>
    <div class="img-selector">
        <b-dropdown id="selOpener"
                    :disabled="working"
                    variant="outline-secondary">
            <template slot="button-content">
                <span v-if="selfSelected === null">Select Image</span>
                <span v-else>
                    <img :src="selfSelected.thumb"
                         v-if="selfSelected.thumb"
                         :alt="selfSelected.name">

                    <img :src="selfSelected.url"
                         height="48px"
                         v-else
                         :alt="selfSelected.name">
                </span>
            </template>

            <b-dropdown-item @click="selfSelected = null">None</b-dropdown-item>

            <b-dropdown-item v-for="(img, i) in images"
                             :key="i"
                             @click="selfSelected = img">
                <img :src="img.thumb" :alt="img.name">
            </b-dropdown-item>
        </b-dropdown>
    </div>
</template>

<script>
  import mediaApi from '../../services/api/mediaApi'

  export default {
    beforeMount () {
      this.fetchData()
    },

    computed: {
      working () {
        return this.$store.state.working
      }
    },

    created () {
      this.selfSelected = this.selected
    },

    data () {
      return {
        selfSelected: null,
        images: []
      }
    },

    methods: {
      fetchData () {
        mediaApi.images()
          .then(r => { this.images = r })
      }
    },

    name: 'image-selector',

    props: {
      selected: {
        required: false,
        type: String,
        default: null
      },
      value: {
        required: true,
      }
    },

    watch: {
      selfSelected () {
        let name = null

        if (this.selfSelected && this.selfSelected.hasOwnProperty('name')) {
          name = this.selfSelected.name
        }

        this.$emit('input', name)
      }
    }
  }
</script>

<style lang="sass" scoped>

</style>
