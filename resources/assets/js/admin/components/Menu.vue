<template>
    <b-navbar toggleable="md"
              type="dark"
              variant="dark"
              fixed="top">
        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand to="/admin">{{ brand }}</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">
            <b-navbar-nav>
                <b-nav-item exact to="/admin/">Dashboard</b-nav-item>
                <b-nav-item to="/admin/pages">Pages</b-nav-item>
                <b-nav-item to="/admin/modules">Modules</b-nav-item>
                <b-nav-item to="/admin/media">Media</b-nav-item>
                <b-nav-item to="/admin/users">Users</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto user-nav">
                <span class="user-pic"><img :src="$store.state.user.gravatar"
                                            width="24"
                                            height="24"
                                            :alt="$store.state.user.name"></span>

                <router-link class="user-name"
                             title="Profile"
                             to="/admin/profile">{{ $store.state.user.name }}</router-link>

                <a class="logout"
                   title="Logout"
                   href="#"
                   @click.prevent="logout()"><span class="ti-power-off"/></a>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
  import authApi from '../services/api/authApi'

  import { mapActions } from 'vuex'
  import { alertConfirm } from '../services/notifications'

  export default {
    methods: {
      ...mapActions(['unSetUser']),

      logout () {
        alertConfirm('Are you leaving, ma biche?')
          .then(go => {
            if (go) {
              authApi.logout()
                .then(() => {
                  this.unSetUser()
                  window.location.href = '/login'
                })
            }
          })
      }
    },

    name: 'Menu',

    props: {
      brand: {
        required: true,
        type: String
      }
    }
  }
</script>

<style lang="sass" scoped>
    .bg-dark
        background-color: #333!important
        border-bottom: 1px solid #222
    .user-name
        color: rgba(255, 255, 255, 0.5)
        &:hover, &:active, &.router-link-active
            text-decoration: none
            color: rgba(255, 255, 255, 0.75)
</style>
