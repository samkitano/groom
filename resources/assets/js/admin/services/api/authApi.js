import http from 'axios'
import { vomit } from './Api'

const authApi = {
  logout () {
    return http.post(`/logout`)
      .then(() => Promise.resolve(true))
      .catch(e => vomit(e))
  }
}

export default authApi
