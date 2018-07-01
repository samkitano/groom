import http from 'axios'
import { apiBase, vomit } from './Api'

const logArchivesApi = {
  index () {
    return http.get(`${apiBase}/log-archives`)
      .then(r => Promise.resolve(r.data.archives))
      .catch(e => vomit(e))
  },

  archive (log) {
    return http.patch(`${apiBase}/log-archives/${log}`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  master () {
    return http.post(`${apiBase}/log-archives`)
      .then(() => Promise.resolve(true))
      .catch((e) => vomit(e))
  },

  delete (name) {
    return http.delete(`${apiBase}/log-archives/${name}`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  deleteAll () {
    return http.delete(`${apiBase}/log-archives/delete-all`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  deleteMaster () {
    return http.delete(`${apiBase}/log-archives-master`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  masterExists () {
    return http.get(`${apiBase}/log-archives-master-exists`)
      .then(r => Promise.resolve(r.data))
      .catch(e => vomit(e))
  }
}

export default logArchivesApi
