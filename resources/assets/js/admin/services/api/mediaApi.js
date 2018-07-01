import http from 'axios'
import { apiBase, vomit } from './Api'

const mediaBaseUri = `${apiBase}/media`

const mediaApi = {
  index () {
    return http.get(`${mediaBaseUri}`)
      .then(r => Promise.resolve(r.data.media))
      .catch(e => vomit(e))
  },

  images () {
    return http.get(`${mediaBaseUri}/images`)
      .then(r => Promise.resolve(r.data.images))
      .catch(e => vomit(e))
  },

  get (id) {
    return http.get(`${mediaBaseUri}/${id}`)
      .then(r => Promise.resolve(r.data.medium))
      .catch(e => vomit(e))
  },

  delete (file) {
    let payload = {
      _method: 'DELETE'
    }

    let id = typeof file === 'number' ? file : 0

    if (id === 0) {
      payload.file = file
    }

    return http.post(`${mediaBaseUri}/${id}`, payload)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  endpoint () {
    return http.get(`${mediaBaseUri}/url`)
      .then(r => Promise.resolve(r.data.url))
      .catch(e => vomit(e))
  }
}

export default mediaApi
