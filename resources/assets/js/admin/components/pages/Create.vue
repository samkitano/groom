<template>
    <section class="admin-pages" v-if="$store.state.loaded">
        <form-wizard color="#80bdff"
                     error-color="#e74c3c"
                     shape="circle"
                     step-size="sm"
                     subtitle="Follow the steps"
                     title="Create a new page"
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
  import help from '../_reusable/popover'
  import editor from '@tinymce/tinymce-vue'
  import pagesApi from '../../services/api/pagesApi'
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
  import { alertSuccess } from '../../services/notifications'
    //TODO FIXME slugs not being translated. shit!
  export default {
    beforeMount () {
      this.fetchData()
    },

    components: {
      FormWizard,
      TabContent,
      editor,
      help,
      langSelector
    },

    computed: {
      bodyIndicators () {
        return this._stateIndicators('body')
      },

      headingIndicators () {
        return this._stateIndicators('heading')
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
          let current = this.page.seo[lang].length > 0

          if (!current) {
            return false
          }
        }

        return true
      }
    },

    data () {
      return {
        page: {
          name: '',
          title: {
            en: '',
            pt: '',
            fr: ''
          },
          seo: {
            en: '',
            pt: '',
            fr: ''
          },
          robots: 'index,follow',
          route_name: '',
          heading: {
            en: '',
            pt: '',
            fr: ''
          },
          body: {
            en: '',
            pt: '',
            fr: ''
          }
        },
        errorMsg: null,
        initMce,
        lang: 'en',
        loadingWizard: false,
        robotsChk: true
      }
    },

    methods: {
      ...mapActions(['setLoaded']),

      _stateIndicators (field) {
        if (!this.$store.state.loaded) {
          return []
        }

        let res = []

        for(let l in this.$store.state.langs) {
          res.push(this.page[field][this.$store.state.langs[l]].length > 0)
        }

        return res
      },

      fetchData () {
        this.setLoaded()
      },

      handleValidation (isValid, tabIndex) {
        if (tabIndex === 0 && isValid) {
          this.page.title.en = this.page.name
          this.page.title.pt = this.page.name
          this.page.title.fr = this.page.name
        }

        if (tabIndex === 1 && isValid) {
          this.page.seo.en = this.page.heading.en
          this.page.seo.pt = this.page.heading.pt
          this.page.seo.fr = this.page.heading.fr
        }

        this.lang = this.$store.state.langs[0]
        // console.log('Tab: '+tabIndex+ ' valid: '+isValid)
      },

      handleErrorMessage (errorMsg) {
        this.errorMsg = errorMsg
      },

      onComplete () {
        pagesApi.store(this.page)
          .then(() => {
            alertSuccess('DONE!', 'Page Created', )
              .then(() => { this.$router.push('/admin/pages') })
          })
      },

      setLoading (value) {
        this.loadingWizard = value
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

          pagesApi.check(this.page.name)
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

    name: 'create-page',

    watch: {
      robotsChk (state) {
        this.page.robots = state
          ? 'index,follow'
          : 'noindex,nofollow,noydir,noodp,noarchive'

        this.errorMsg = null
      }
    }
  }
</script>
