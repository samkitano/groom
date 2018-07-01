import http from 'axios'
import { apiBase, vomit } from './Api'

const logsBaseUri = `${apiBase}/logs`

const logsApi = {
  index () {
    return http.get(logsBaseUri)
      .then(r => Promise.resolve(r.data.logs))
      .catch(e => vomit(e))
  },

  get (log) {
    return http.get(`${logsBaseUri}/${log}`)
      .then(r => Promise.resolve(r.data[log]))
      .catch(e => vomit(e))
  },

  delete (log) {
    return http.delete(`${logsBaseUri}/${log}`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  },

  deleteAll () {
    return http.delete(`${logsBaseUri}/delete-all`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  }
}

export default logsApi
