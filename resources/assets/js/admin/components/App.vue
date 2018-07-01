<template>
    <main>
        <div :class="graderClass"/>

        <header>
            <app-nav :brand="appName"/>
        </header>

        <section class="content">
            <page-heading/>

            <div class="w">
                <div class="l">
                    <t-bar/>
                </div>

                <div class="r">
                    <router-view/>
                </div>
            </div>
        </section>

        <app-footer/>
    </main>
</template>

<script>
  import appNav from './Menu'
  import appFooter from './Footer'
  import tBar from './_reusable/tool-bar'
  import pageHeading from './_reusable/page-heading'

  import { mapActions } from 'vuex'

  export default {
    beforeDestroy () {
      Bus.$off('working', this.emitWorking)
      Bus.$off('requesting', this.emitRequesting)
    },

    beforeMount () {
      Bus.$on('working', this.emitWorking)
      Bus.$on('requesting', this.emitRequesting)
      this.setUser(this.user)
      this.unSetLoaded()
      this.unSetCount()
      this.unSetEditingName()
      this.setCanSaveBtn(false)
      this.setApp({
        appName: this.appName,
        baseDir: this.baseDir
      })
    },

    components: {
      appFooter,
      appNav,
      pageHeading,
      tBar
    },

    computed: {
      graderClass () {
        let comm = 'g'

        if (this.$store.state.requesting !== '') {
          comm += ' a'
        }

        return comm
      }
    },

    methods: {
      ...mapActions([
        'setApp',
        'setCanSaveBtn',
        'setUser',
        'unSetCount',
        'unSetEditingName',
        'unSetLoaded',
        'setWorking',
        'unSetWorking',
        'setRequesting'
      ]),

      emitRequesting (method) {
        this.setRequesting(method)
      },

      emitWorking (state) {
        state
          ? this.setWorking()
          : this.unSetWorking()
      }
    },

    name: 'App',

    props: {
      appName: {
        required: true,
        type: String
      },
      baseDir: {
        required: true,
        type: String
      },
      user: {
        required: true
      }
    },

    watch: {
      $route () {
        this.unSetLoaded()
        this.unSetCount()
        this.unSetEditingName()
        this.setCanSaveBtn(false)
        Bus.$emit('setActiveTBtn', 'stats')
      }
    }
  }
</script>

<style lang="sass" scoped>
    .w
        display: inline-block
        width: 100%
        margin-top: 2rem
        .l
            width: 4rem
            float: left
            margin-left: 1rem
        .r
            width: calc(100% - 5rem)
            display: block
            padding: 0 calc(1rem + 6px) 2rem 1rem
            float: left

    .g
        width: 100%
        position: absolute
        top: 0
        left: 0
        z-index: 99999
        background: transparent
        height: 3px
        &.a
            background: linear-gradient(90deg, #343a40, #ffc107)
            background-size: 400% 400%
            -webkit-animation: gradder 1s ease infinite
            -moz-animation: gradder 1s ease infinite
            -o-animation: gradder 1s ease infinite
            animation: gradder 1s ease infinite
</style>
