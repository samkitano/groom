<template>
    <div class="ph">
        <div class="ph-left">
            <div class="ph-left-top">
                <div class="current">COUNT: <span class="count" v-html="elsCount"/></div>
                <div class="current">ID: <span class="id" v-html="elId"/></div>
                <div class="current">NAME: <span class="name" v-html="elName"/></div>
            </div>

            <div class="ph-left-middle">
                <h1 class="title" v-html="title"/>
                <div class="request-indicators">
                    <div :class="loaded && !working ? 'loading' : 'loading animate'"/>

                    <div class="method-indicators">
                        <div :class="requesting === 'get' ? 'active' : ''">get</div>
                        <div :class="requesting === 'post' ? 'active' : ''">post</div>
                        <div :class="requesting === 'patch' ? 'active' : ''">patch</div>
                        <div :class="requesting === 'update' ? 'active' : ''">update</div>
                        <div :class="requesting === 'delete' ? 'active' : ''">delete</div>
                    </div>
                </div>
            </div>

            <div class="ph-left-bottom">
                <div :class="isIndex ? 'current' : ''">INDEX</div>
                <div :class="isCreate ? 'current' : ''">CREATE</div>
                <div :class="isEdit ? 'current' : ''">EDIT</div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    computed: {
      requesting () {
        return this.$store.state.requesting
      },

      elId () {
        return this.$route.params.id || '---'
      },

      elName () {
        return this.$store.state.editingName || '---'
      },

      elsCount () {
        return this.$store.state.count || 0
      },

      isCreate () {
        return this.$route.meta.crud === 1
      },

      isEdit () {
        return this.$route.meta.crud === 2
      },

      isIndex () {
        return this.$route.meta.crud === 0
      },

      loaded () {
        return this.$store.state.loaded
      },

      title () {
        return this.$route.meta.name
      },

      working () {
        return this.$store.state.working
      }
    },

    name: 'page-heading'
  }
</script>

<style lang="sass" scoped>
    .ph
        font-family: 'hack', monospace
        display: inline-block
        background-color: #333
        width: 100%
        &-left
            &-top, &-middle, &-bottom
                padding: 0 1.25rem
            &-middle
                color: #ffc107
                display: flex
                border-top: 1px solid #222
                border-bottom: 1px solid #222
                justify-content: space-between
                align-items: center

                .request-indicators
                    display: flex
                    align-items: center

                    .method-indicators
                        font-size: .6rem
                        padding-left: .5rem
                        color: #4b4b4b
                        border-left: 1px solid #222

                        div.active
                            color: #ffc107

            &-top, &-bottom
                color: #4b4b4b
                display: flex
                align-items: center
                justify-content: space-between
                font-size: .8rem

    .current
        color: #ffc107

    .loading
        margin-left: .5rem
        margin-right: .5rem
        display: flex
        position: relative
        justify-content: center
        width: 32px
        height: 32px

        &:after
            content: " "
            display: block
            border-radius: 50%
            width: 0
            height: 0
            box-sizing: border-box
            border: 16px solid
            border-color: #444 #212529 #444 #212529

        &.animate
            &:after
                border-color: #ffc107 #212529 #ffc107 #212529
                animation: loading 1.2s infinite
</style>
