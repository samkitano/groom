'use strict'

import VueRouter from 'vue-router'
import Profile from './components/Profile'
import Media from './components/media/Index'
import Pages from './components/pages/Index'
import EditPage from './components/pages/Edit'
import EditMedia from './components/media/Edit'
import Modules from './components/modules/Index'
import EditModule from './components/modules/Edit'
import CreatePage from './components/pages/Create'
import Dashboard from './components/dashboard/Index'
import CreateMedia  from './components/media/Create'
import CreateModule from './components/modules/Create'
import Users from './components/users/Index'
import EditUser from './components/users/Edit'
import CreateUser from './components/users/Create'

let routes = [
  {
    path: '/admin',
    component: Dashboard,
    meta: { name: 'Dashboard', crud: 0, parent: '/admin', toolbar: 0 }
  },
  {
    path: '/admin/profile',
    component: Profile,
    meta: { name: 'Profile', crud: 0, parent: '/admin/profile', toolbar: 2 }
  },
  {
    path: '/admin/pages',
    component: Pages,
    meta: { name: 'Pages', crud: 0, parent: '/admin/pages', toolbar: 1 }
  },
  {
    path: '/admin/pages/create',
    component: CreatePage,
    meta: { name: 'Pages', crud: 1, parent: '/admin/pages', toolbar: 1 }
  },
  {
    path: '/admin/pages/:id',
    component: EditPage,
    meta: { name: 'Pages', crud: 2, parent: '/admin/pages', toolbar: 1 }
  },
  {
    path: '/admin/modules',
    component: Modules,
    meta: { name: 'Modules', crud: 0, parent: '/admin/modules', toolbar: 1 }
  },
  {
    path: '/admin/modules/create',
    component: CreateModule,
    meta: { name: 'Modules', crud: 1, parent: '/admin/modules', toolbar: 1 }
  },
  {
    path: '/admin/modules/:id',
    component: EditModule,
    meta: { name: 'Modules', crud: 2, parent: '/admin/modules', toolbar: 1 }
  },
  {
    path: '/admin/media',
    component: Media,
    meta: { name: 'Media', crud: 0, parent: '/admin/media', toolbar: 1 }
  },
  {
    path: '/admin/media/create',
    component: CreateMedia,
    meta: { name: 'Media', crud: 1, parent: '/admin/media', toolbar: 1 }
  },
  {
    path: '/admin/media/:id',
    component: EditMedia,
    meta: { name: 'Media', crud: 2, parent: '/admin/media', toolbar: 1 }
  },
  {
    path: '/admin/users',
    component: Users,
    meta: { name: 'Users', crud: 0, parent: '/admin/users', toolbar: 1 }
  },
  {
    path: '/admin/users/:id',
    component: EditUser,
    meta: { name: 'Users', crud: 2, parent: '/admin/users', toolbar: 1 }
  },
  {
    path: '/admin/users/create',
    component: CreateUser,
    meta: { name: 'Users', crud: 1, parent: '/admin/users', toolbar: 1 }
  }
]

export default new VueRouter({
  abstract: true,
  mode: 'history',
  routes,
  scrollBehavior () {
    return { x: 0, y: 0 }
  }
})
