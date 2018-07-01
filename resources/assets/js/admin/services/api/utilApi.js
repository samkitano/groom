import http from 'axios'
import { apiBase, vomit } from './Api'

const utilBaseUri = `${apiBase}/util`

const utilApi = {
  execArtisanCommand (payload) {
    return http.patch(`${utilBaseUri}/exec`, payload)
      .then(r => Promise.resolve(r.data.output))
      .catch(e => vomit(e))
  }
}

export default utilApi
