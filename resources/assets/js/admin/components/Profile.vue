<template>
    <article class="admin-profile">
        <b-card border-variant="info"
                no-body
                :header="header">
            <b-card-body class="p-0">
                <div class="user-card">
                    <div class="user-img">
                        <b-img fluid
                               :src="$store.state.user.gravatar"
                               :alt="$store.state.user.name"/>
                    </div>

                    <div class="user-form">
                        <collapse-transition>
                            <div v-if="showView === 'chgName'">
                                <h4>Change your name</h4>

                                <b-form-input id="name"
                                              v-model.trim="name"
                                              type="text"
                                              class="mb-2"
                                              :state="nameState"
                                              aria-describedby="nameFeedback"
                                              placeholder="Enter your name"/>

                                <b-form-invalid-feedback id="nameFeedback"
                                                         class="mb-2"
                                                         v-html="nameFeedback"/>
                            </div>

                            <div v-if="showView === 'chgPw'">
                                <h4>Change your password</h4>

                                <b-form-input id="password"
                                              class="mb-2"
                                              v-model="password"
                                              type="password"
                                              :state="passwordState"
                                              aria-describedby="passwordFeedback"
                                              placeholder="Enter your new password"/>

                                <b-form-input id="password_confirmation"
                                              class="mb-2"
                                              v-model="password_confirmation"
                                              type="password"
                                              placeholder="Repeat your new password"/>

                                <b-form-invalid-feedback id="passwordFeedback"
                                                         class="mb-4"
                                                         v-html="passwordFeedback"/>

                            </div>

                            <div v-if="showView === 'chgEmail'">
                                <h4>Change your E-mail address</h4>

                                <b-form-input id="email"
                                              class="mb-2"
                                              v-model.trim="email"
                                              type="email"
                                              :state="emailState"
                                              aria-describedby="emaiFeedback"
                                              placeholder="Enter your new email"/>

                                <b-form-input id="email_confirmation"
                                              class="mb-2"
                                              v-model.trim="email_confirmation"
                                              type="email"
                                              placeholder="Confirm your new email"/>

                                <b-form-invalid-feedback id="emailFeedback"
                                                         class="mb-4"
                                                         v-html="emailFeedback"/>
                            </div>
                        </collapse-transition>
                    </div>
                </div>
            </b-card-body>
        </b-card>
    </article>
</template>

<script>
  import usersApi from '../services/api/usersApi'

  import { head } from 'lodash'
  import { mapActions } from 'vuex'
  import { CollapseTransition } from 'vue2-transitions'
  import { alertSuccess, alertError } from '../services/notifications'

  export default {
    beforeDestroy () {
      Bus.$off('save', this.change)
      Bus.$off('show', this.show)
    },

    beforeMount () {
      this.fetchData()
      Bus.$on('save', this.change)
      Bus.$on('show', this.show)
    },

    components: {
      CollapseTransition
    },

    computed: {
      header () {
        return `${this.$store.state.user.name} &lt;${this.$store.state.user.email}&gt;`
      }
    },

    data () {
      return {
        changed: false,
        email: this.$store.state.user.email,
        email_confirmation: '',
        emailFeedback: '',
        emailState: '',
        name: this.$store.state.user.name,
        nameFeedback: '',
        nameState: '',
        password: '',
        passwordState: '',
        passwordFeedback: '',
        password_confirmation: '',
        payload: {},
        showView: ''
      }
    },

    methods: {
      ...mapActions(['setLoaded', 'setUser', 'setEditingName', 'unSetLoaded', 'setCanSaveBtn']),

      change () {
        this.unSetLoaded()
        this.setPayload()

        usersApi.update(this.$store.state.user.id, this.payload)
          .then((r) => {
            this.setUser(r.user)
            this.resetForm()
            this.changed = false
            alertSuccess(r.message)
          })
          .catch((e) => {
            let error = e.errors
            let field = Object.keys(error)[0]
            let msg = head(error[field])

            switch (field) {
              case 'name':
                this.nameState = false
                this.nameFeedback = msg
                break
              case 'email' || 'email_confirmation':
                this.emailState = false
                this.emailFeedback = msg
                break
              case 'password' || 'password_confirmation':
                this.passwordState = false
                this.passwordFeedback = msg
                break
              default:
                alertError(e.message)
            }
          })
          .finally(() => {
            this.payload = {}
            this.setLoaded()
          })
      },

      fetchData () {
        this.setLoaded()
        this.setEditingName('user')
      },

      resetForm () {
        this.email = this.$store.state.user.email
        this.email_confirmation = ''
        this.emailFeedback = ''
        this.emailState = ''
        this.name = this.$store.state.user.name
        this.nameFeedback = ''
        this.nameState = ''
        this.password = ''
        this.passwordState = ''
        this.passwordFeedback = ''
        this.password_confirmation = ''
      },

      setPayload () {
        if (this.name !== this.$store.state.user.name) {
          this.payload.name = this.name
        }

        if (this.email !== this.$store.state.user.email) {
          this.payload.email = this.email
          this.payload.email_confirmation = this.email_confirmation
        }

        if (this.password.length > 0) {
          this.payload.password = this.password
          this.payload.password_confirmation = this.password_confirmation
        }
      },

      show (view) {
        if (this.showView === view) {
          this.showView = ''
        } else {
          if (this.showView === '') {
            this.showView = view
          } else {
            this.showView = ''
            setTimeout(() => {
              this.showView = view
            }, 300)
          }
        }
      },
    },

    name: 'profile',

    watch: {
      changed () {
        this.setCanSaveBtn(this.changed)
      },
      email () {
        this.changed = this.email !== this.$store.state.user.email
      },
      name () {
        this.changed = this.name !== this.$store.state.user.name
      },
      password () {
        this.changed = this.password.length > 0
      },
      showView () {
        Bus.$emit('setActiveTBtn', this.showView)
        this.resetForm()
      }
    }
  }
</script>

<style lang="sass" scoped>
    .user-card
        display: flex
        align-items: center
        .user-img
            max-width: 256px
        .user-form
            flex-grow: 1
            display: block
            padding: 0 2rem
            h4
                margin-bottom: 1rem

    @media (max-width: 700px)
        .user-card
            flex-direction: column
            .user-form
                margin-top: 2rem
                margin-bottom: 2rem
</style>
