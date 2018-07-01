import http from 'axios'
import { apiBase, vomit } from './Api'

const pagesBaseUri = `${apiBase}/pages`

const pagesApi = {
  index () {
    return http.get(pagesBaseUri)
      .then(r => Promise.resolve(r.data.pages))
      .catch(e => vomit(e))
  },

  list () {
    return http.get(`${pagesBaseUri}/list`)
      .then(r => Promise.resolve(r.data.list))
      .catch(e => vomit(e))
  },

  get (page) {
    return http.get(`${pagesBaseUri}/${page}`)
      .then(r => Promise.resolve(r.data.page))
      .catch(e => vomit(e))
  },

  store (payload) {
    return http.post(`${pagesBaseUri}`, payload)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  update(page, payload) {
    return http.patch(`${pagesBaseUri}/${page}`, payload)
      .then(r => Promise.resolve(r.data.page))
      .catch(e => vomit(e))
  },

  delete (page) {
    return http.delete(`${pagesBaseUri}/${page}`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  check (name, id) {
    let payload = { name }

    if (id !== undefined || !id) {
      payload.id = id
    }

    return http.patch(`${pagesBaseUri}/check`, payload)
      .then(() => Promise.resolve(true))
      .catch(e => Promise.reject(e.response.data))
  }
}

export default pagesApi
