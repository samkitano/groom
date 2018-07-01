import http from 'axios'
import { apiBase, vomit, createBlob, uuid } from './Api'

const downloadsApi = {
  getRaw (log) {
    return http.get(`${apiBase}/log-download/${log}`, { responseType: 'blob' })
      .then(r => createBlob(r.data, `${uuid()}.txt`))
      .catch(e => vomit(e))
  },

  getArchived (log) {
    return http.get(`${apiBase}/log-download-archive/${log}`, { responseType: 'blob' })
      .then(r => createBlob(r.data, `${uuid()}.zip`))
      .catch(e => vomit(e))
  },

  getMaster () {
    return http.get(`${apiBase}/log-download-master`, { responseType: 'blob' })
      .then(r => createBlob(r.data, `${uuid()}.zip`))
      .catch(e => vomit(e))
  }
}

export default downloadsApi
