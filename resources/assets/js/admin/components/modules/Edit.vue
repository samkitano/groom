<template>
    <article class="admin-modules">
        <form-wizard color="#80bdff"
                     error-color="#e74c3c"
                     shape="circle"
                     step-size="sm"
                     subtitle="Follow the steps"
                     :title="`Edit Module #${module.id}`"
                     v-if="$store.state.loaded"
                     @on-complete="onComplete"
                     @on-error="handleErrorMessage"
                     @on-loading="setLoading"
                     @on-validate="handleValidation">
            <tab-content title="Properties"
                         :before-change="validateProperties"
                         icon="ti-settings">

                <b-input-group prepend="Name"
                               class="mb-4">
                    <b-form-input v-model="module.name"
                                  type="text"
                                  autofocus
                                  placeholder="Module Name"/>
                    <help id="moduleName" slot="append"/>
                </b-input-group>

                <page-selector v-model="module.page_id"/>

                <b-input-group prepend="More"
                               class="mb-4">
                    <b-form-select v-model="module.more"
                                   :disabled="module.page_id !== 1"
                                   :options="pageNames">
                        <template slot="first">
                            <option :value="null" disabled>-- Select --</option>
                        </template>
                    </b-form-select>

                    <help id="moduleMore" slot="append"/>
                </b-input-group>
            </tab-content>

            <tab-content title="Heading"
                         :before-change="validateTitle"
                         icon="ti-layout-sidebar-right l90">
                <div class="tab-header">
                    <lang-selector v-model="lang"
                                   :indicators="titleIndicators"/>
                </div>

                <b-input-group :prepend="`Heading [${lang}]`"
                               class="mb-4">
                    <b-form-input v-model="module.title[lang]"
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
                    <editor :init="initMce" v-model="module.body[lang]"/>
                </div>
            </tab-content>

            <tab-content title="Image"
                         icon="ti-instagram">
                <help id="moduleImage" label/>

                <img-selector class="mb-4"
                              v-model="module.image"
                              :selected="module.image"/>

                <b-form-checkbox id="imageOutside"
                                 v-model="module.image_outside"
                                 :disabled="module.image === null"
                                 class="mb-4"
                                 :value="true"
                                 :unchecked-value="false">
                    Place image {{ module.image_outside ? 'OUTSIDE ' : 'INSIDE (as background)'}} the module
                </b-form-checkbox>
            </tab-content>

            <tab-content title="Style"
                         icon="ti-palette">
                <b-input-group prepend="Class"
                               class="mb-4">
                    <b-form-input v-model="module.css_class"
                                  type="text"
                                  placeholder="Module CSS Class"/>
                    <help id="moduleCssClass" slot="append"/>
                </b-input-group>

                <css-man class="mb-4" @add="addCss"/>

                <b-table striped
                         hover
                         v-show="cssTableItems.length"
                         :fields="cssTableFields"
                         :items="cssTableItems">
                    <template slot="value" slot-scope="data">
                        {{ data.value }}
                        <span class="sample"
                              :style="`background-color: ${data.value}`"
                              v-if="data.item.rule.includes('color')"/>
                    </template>

                    <template slot="actions" slot-scope="row">
                        <b-btn title="Delete"
                               size="sm"
                               variant="outline-danger"
                               @click.stop="deleteRule(row.item.rule)"><span class="ti-trash"/></b-btn>

                        <b-btn title="Edit"
                               size="sm"
                               variant="outline-primary"
                               @click.stop="editRule(row.item)"
                        ><span class="ti-pencil-alt"></span></b-btn>
                    </template>
                </b-table>
            </tab-content>

            <tab-content title="Finish"
                         icon="ti-check">
                <div class="tab-header">
                    <lang-selector v-model="lang"/>
                </div>

                <preview :item="module" :lang="lang"/>
            </tab-content>

            <div class="loader" v-if="loadingWizard"/>

            <div v-if="errorMsg">
                <span class="error" v-html="errorMsg"/>
            </div>
        </form-wizard>

    </article>
</template>

<script>
  import tinymce from 'tinymce'
  import help from '../_reusable/popover'
  import editor from '@tinymce/tinymce-vue'
  import cssMan from '../_reusable/css-man'
  import preview from '../_reusable/preview'
  import pagesApi from '../../services/api/pagesApi'
  import modulesApi from '../../services/api/modulesApi'
  import imgSelector  from '../_reusable/image-selector'
  import pageSelector  from '../_reusable/page-selector'
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
  import { alertConfirm, alertSuccess } from '../../services/notifications'

  export default {
    beforeDestroy () {
      Bus.$off('save', this.saveChanges)
      Bus.$off('delete', this.deleteModule)
    },

    beforeMount () {
      this.fetchData()

      Bus.$on('save', this.saveChanges)
      Bus.$on('delete', this.deleteModule)
    },

    components: {
      editor,
      help,
      langSelector,
      cssMan,
      preview,
      FormWizard,
      TabContent,
      imgSelector,
      pageSelector
    },

    computed: {
      bodyIndicators () {
        return this._stateIndicators('body')
      },

      cssTableItems () {
        let res = []

        for (let item in this.module.css) {
          res.push({ rule: item, value: this.module.css[item] })
        }

        return res
      },

      pageNames () {
        let res = []

        for (let item in this.pagesList) {
          res.push(this.pagesList[item].text)
        }

        return res
      },

      titleIndicators () {
        return this._stateIndicators('title')
      },

      working () {
        return this.$store.state.working
      }
    },

    data () {
      return {
        cssTableFields: ['rule', 'value', 'actions'],
        customCss: '',
        errorMsg: null,
        initMce,
        lang: 'en',
        loadingWizard: false,
        module: {},
        moduleExists: false,
        pagesList: []
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'setEditingName', 'setCanSaveBtn']),

      _stateIndicators (field) {
        if (!this.$store.state.loaded) {
          return []
        }

        let res = []

        for(let l in this.$store.state.langs) {
          res.push(this.module[field][this.$store.state.langs[l]].length > 0)
        }

        return res
      },

      addCss (css) {
        if (this.module.css.hasOwnProperty(css.rule)) {
          this.module.css[css.rule] = css.value
        } else {
          this.$set(this.module.css, css.rule, css.value)
        }
      },

      deleteRule (rule) {
        if (this.module.css.hasOwnProperty(rule)) {
          this.$delete(this.module.css, rule)
        }
      },

      editRule (item) {
        Bus.$emit('openCssMan', { rule: item.rule, value: item.value })
      },

      deleteModule () {
        alertConfirm(`Are you sure you want to delete the module "${this.module.name}"?`)
          .then(go => {
            if (!go) {
              return false
            }

            modulesApi.delete(this.module.id)
              .then(() => {
                alertSuccess('DONE!', 'Module deleted!')
                  .then(() => { this.$router.push({ path: '/admin/modules' }) })
              })
          })
      },

      fetchData () {
        modulesApi.get(this.$route.params.id)
          .then(r => {
            this.module = r

            pagesApi.list().then(r => { this.pagesList = r })
          })
          .finally(() => {
            this.setEditingName(this.module.name)
            this.setLoaded()
          })
      },

      handleErrorMessage (errorMsg) {
        this.errorMsg = errorMsg
      },

      handleValidation (isValid, tabIndex) {
        this.lang = this.$store.state.langs[0]

        if (isValid) {
          this.setCanSaveBtn(true)
        }
      },

      noop () {},

      saveChanges() {
        if (this.errorMsg !== null) {
          return false
        }

        this.onComplete()
      },

      onComplete () {
        modulesApi.update(this.$route.params.id, { module: this.module })
          .then(() => {
            alertSuccess('UPDATED!', `Successfully updated the Module "${this.module.name}"`)
              .then(() => { this.$router.push({ path: '/admin/modules' }) })
          })
      },

      setLoading (value) {
        this.loadingWizard = value
      },

      validateBody () {
        return new Promise((resolve, reject) => {
          let isValid = this.validateAllOrNone(this.module.body, 'Text')

          if (isValid === true) {
            resolve(true)
          } else {
            reject(isValid)
          }
        })
      },

      validateProperties () {
        return new Promise((resolve, reject) => {
          if (!this.validateNotEmptyStr(this.module.name)) {
            reject('The new module MUST have a name!')
          }

          if (!this.validateHasOnlyLettersAndNumbers(this.module.name)) {
            reject('The module name can only contain letters and numbers!')
          }

          modulesApi.check(this.module.name, this.$route.params.id)
            .then(() => { resolve(true) })
            .catch(e => { reject(e) })
        })
      },

      validateTitle () {
        return new Promise((resolve, reject) => {
          let isValid = this.validateAllOrNone(this.module.title, 'Heading')

          if (isValid === true) {
            resolve(true)
          } else {
            reject(isValid)
          }
        })
      }
    },

    name: 'edit-module'
  }
</script>
