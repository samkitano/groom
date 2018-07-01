<template>
    <section class="admin-modules">
        <form-wizard color="#80bdff"
                     error-color="#e74c3c"
                     shape="circle"
                     step-size="sm"
                     subtitle="Follow the steps"
                     :title="`Edit page #${page.id}`"
                     v-if="loaded"
                     @on-complete="onComplete"
                     @on-error="handleErrorMessage"
                     @on-loading="setLoading"
                     @on-validate="handleValidation">
            <tab-content title="Properties"
                         :before-change="validateProperties"
                         icon="ti-settings">
                <b-input-group prepend="Name"
                               class="mb-4">
                    <b-form-input v-model="page.name"
                                  type="text"
                                  autofocus
                                  placeholder="Page Name"/>
                    <help id="pageName" slot="append"/>
                </b-input-group>

                <b-input-group prepend="Route"
                               class="mb-4">
                    <b-form-input v-model="page.route_name"
                                  type="text"
                                  placeholder="Route name"/>
                    <help id="routeName" slot="append"/>
                </b-input-group>
            </tab-content>

            <tab-content title="Headings"
                         :before-change="validateHeading"
                         icon="ti-layout-sidebar-right l90">
                <div class="tab-header">
                    <lang-selector v-model="lang"
                                   :indicators="headingIndicators"/>
                </div>

                <b-input-group :prepend="`Heading [${lang}]`"
                               class="mb-4">
                    <b-form-input v-model="page.heading[lang]"
                                  type="text"
                                  :placeholder="`Heading ${lang}`"/>
                    <help id="moduleHeading" slot="append"/>
                </b-input-group>
            </tab-content>

            <tab-content title="Body"
                         :before-change="validateBody"
                         icon="ti-layout-width-default l90">
                <help id="moduleText" label/>

                <div class="tab-header">
                    <lang-selector v-model="lang" :indicators="bodyIndicators"/>
                </div>

                <div class="mb-4">
                    <label>Body [{{lang}}]</label>
                    <editor :init="initMce" v-model="page.body[lang]"/>
                </div>
            </tab-content>

            <tab-content title="SEO - I"
                         :before-change="validateTitle"
                         icon="ti-bookmark-alt">
                <div class="tab-header">
                    <lang-selector v-model="lang" :indicators="titleIndicators"/>
                </div>

                <b-input-group :prepend="`Title [${lang}]`"
                               class="mb-4">
                    <b-form-input v-model="page.title[lang]"
                                  type="text"
                                  :placeholder="`Title ${lang}`"/>

                    <help id="pageTitle" slot="append"/>
                </b-input-group>
            </tab-content>

            <tab-content title="SEO - II"
                         :before-change="validateSeo"
                         icon="ti-bookmark-alt">
                <div class="tab-header">
                    <lang-selector v-model="lang"
                                   :disabled="!robotsChk"
                                   :valid="validSeo || !robotsChk"
                                   :indicators="seoIndicators"/>
                </div>

                <b-input-group :prepend="`Description [${lang}]`"
                               class="mb-4">
                    <b-form-input v-model="page.seo[lang]"
                                  type="text"
                                  :disabled="!robotsChk"
                                  :placeholder="`Description ${lang}`"/>
                    <help id="pageDescription" slot="append"/>
                </b-input-group>

                <help id="pageRobots" label/>

                <b-form-checkbox id="indexRobots"
                                 v-model="robotsChk"
                                 class="mb-4"
                                 :value="true"
                                 :unchecked-value="false">
                    Mr. Robot, please {{ !robotsChk ? 'DO NOT ' : ''}}INDEX this page
                </b-form-checkbox>
            </tab-content>

            <tab-content title="Finish"
                         icon="ti-check">
                Click finish button to create the new page
            </tab-content>

            <div class="loader" v-if="loadingWizard"></div>

            <div v-if="errorMsg">
                <span class="error">{{errorMsg}}</span>
            </div>
        </form-wizard>
    </section>
</template>

<script>
  import tinymce from 'tinymce'
  import pagesApi from '../../services/api/pagesApi'
  import help from '../_reusable/popover'
  import editor from '@tinymce/tinymce-vue'
  import modulesComponent from '../modules/Index'
  import langSelector from '../_reusable/lang-selector'

  import 'tinymce/themes/modern/theme'
  import 'tinymce/plugins/link/plugin'
  import 'tinymce/plugins/paste/plugin'
  import 'tinymce/plugins/table/plugin'
  import 'tinymce/plugins/image/plugin'
  import 'tinymce/plugins/autoresize/plugin'

  import 'vue-form-wizard/dist/vue-form-wizard.min.css'

  import { mapActions } from 'vuex'
  import { initMce } from '../../settings/settings'
  import { FormWizard, TabContent } from 'vue-form-wizard'
  import { CollapseTransition } from 'vue2-transitions'
  import {
    alertConfirm,
    alertSuccess,
    noDelHomePage
  } from '../../services/notifications'

  export default {
    beforeDestroy () {
      Bus.$off('save', this.saveChanges)
      Bus.$off('delete', this.deletePage)
    },

    beforeMount () {
      this.fetchData()

      Bus.$on('save', this.saveChanges)
      Bus.$on('delete', this.deletePage)
    },

    components: {
      editor,
      langSelector,
      modulesComponent,
      CollapseTransition,
      help,
      FormWizard,
      TabContent
    },

    computed: {
      bodyIndicators () {
        return this._stateIndicators('body')
      },

      headingIndicators () {
        return this._stateIndicators('heading')
      },

      loaded () {
        return this.$store.state.loaded
      },

      titleIndicators () {
        return this._stateIndicators('title')
      },

      seoIndicators () {
        return this._stateIndicators('seo')
      },

      validSeo () {
        if (!this.robotsChk) {
          return true
        }

        for (let lang in this.page.seo) {
          let page = this.page.seo[lang]
          let current = page && page.length > 0

          if (!current) {
            return false
          }
        }

        return true
      },

      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        errorMsg: null,
        initMce,
        lang: 'en',
        loadingWizard: false,
        page: {},
        robotsChk: true,
        tabIndex: 0
      }
    },

    methods: {
      ...mapActions([
        'setLoaded',
        'setEditingName',
        'toggleAlert',
        'setCanSaveBtn'
      ]),

      _stateIndicators (field) {
        if (!this.$store.state.loaded) {
          return []
        }

        let res = []

        for(let l in this.$store.state.langs) {
          let lang = this.$store.state.langs[l]
          let page = this.page[field][lang]

          res.push(page && page.length > 0)
        }

        return res
      },

      deletePage () {
        if (this.page.name === 'home') {
          noDelHomePage()
          return false
        }

        alertConfirm(`Are you sure you want to delete the page "${this.page.name}"?<br><br><span style="color:darkred">THIS ACTION IS IRREVERSIBLE</span>!`)
          .then(go => {
            if (!go.value) {
              return false
            }

            pagesApi.delete(this.page.id)
              .then(() => {
                alertSuccess('DONE', `Page "${this.page.name}" was deleted!`)
                  .then(() => { this.$router.push({ path: '/admin/pages' }) })
              })
          })
      },

      fetchData () {
        pagesApi.get(this.$route.params.id)
          .then(r => {
            this.page = r
            this.setRobots()
          })
          .finally(() => {
            this.setLoaded()
            this.setEditingName(this.page.name)
          })
      },

      noop () {},

      handleValidation (isValid, tabIndex) {
        if (tabIndex === 0 && isValid) {
          this.page.title.en = this.page.name
          this.page.title.pt = this.page.name
          this.page.title.fr = this.page.name

          this.setCanSaveBtn(true)
        }

        if (tabIndex === 1 && isValid) {
          this.page.seo.en = this.page.heading.en
          this.page.seo.pt = this.page.heading.pt
          this.page.seo.fr = this.page.heading.fr
        }

        this.lang = this.$store.state.langs[0]
      },

      handleErrorMessage (errorMsg) {
        this.errorMsg = errorMsg
      },

      onComplete () {
        pagesApi.update(this.$route.params.id, this.page)
          .then((r) => {
            alertSuccess('SAVED!', `Page "${this.page.name}" has been updated`)
            this.page = r
          })
      },

      saveChanges() {
        if (this.errorMsg !== null) {
          return false
        }

        this.onComplete()
      },

      setLoading (value) {
        this.loadingWizard = value
      },

      setRobots () {
        this.robotsChk = this.page.robots === 'index,follow'
      },

      validateBody () {
        return new Promise((resolve, reject) => {
          let isValid = this.validateAllOrNone(this.page.body, 'Text')

          if (isValid === true) {
            resolve(true)
          } else {
            reject(isValid)
          }
        })
      },

      validateHeading () {
        return new Promise((resolve, reject) => {
          let isValid = this.validateAllOrNone(this.page.heading, 'Heading')

          if (isValid === true) {
            resolve(true)
          } else {
            reject(isValid)
          }
        })
      },

      validateProperties () {
        return new Promise((resolve, reject) => {
          if (!this.validateNotEmptyStr(this.page.name)) {
            reject('The new page MUST have a name')
          }

          if (!this.validateNotEmptyStr(this.page.route_name)) {
            reject('Please provide a Route name for the page')
          }

          if (!this.validateHasOnlyLettersAndNumbers(this.page.name)) {
            reject('The page name can only contain letters and numbers!')
          }

          if (!this.validateHasOnlyLettersAndDots(this.page.route_name)) {
            reject('The route name can only contain letters and dots!')
          }

          pagesApi.check(this.page.name, this.$route.params.id)
            .then(() => { resolve(true) })
            .catch(e => { reject(e) })
        })
      },

      validateSeo () {
        return new Promise((resolve, reject) => {
          let errors = []

          if (this.robotsChk) {
            for (let lang in this.page.seo) {
              if (this.page.seo.hasOwnProperty(lang) && !this.page.seo[lang].length) {
                errors.push(`Description [${lang}] is missing`)
              }
            }
          }

          let res = errors.join('; ')

          if (res.length > 0) {
            reject(res)
          } else {
            resolve(true)
          }
        })
      },

      validateTitle () {
        return new Promise((resolve, reject) => {
          let errors = []

          for (let lang in this.page.title) {
            if (this.page.title.hasOwnProperty(lang) && !this.page.title[lang].length) {
              errors.push(`Title [${lang}] is missing`)
            }
          }

          let res = errors.join('; ')

          if (res.length > 0) {
            reject(res)
          } else {
            resolve(true)
          }
        })
      }
    },

    name: 'edit-page',

    watch: {
      robotsChk (state) {
        this.page.robots = state
          ? 'index,follow'
          : 'noindex,nofollow,noydir,noodp,noarchive'
      },

      errorMsg (e) {
        if (e.length > 0) {
          this.setCanSaveBtn(false)
        } else {
          this.setCanSaveBtn(true)
        }
      },

      working (stt) {
        if (stt) {
          this.setCanSaveBtn(false)
        } else {
          this.setCanSaveBtn(true)
        }
      }
    }
  }
</script>
