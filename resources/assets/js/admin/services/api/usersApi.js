import http from 'axios'
import { apiBase, vomit } from './Api'

const usersApiUri = `${apiBase}/users`

const usersApi = {
  update (id, payload) {
    return http.patch(`${usersApiUri}/${id}`, payload )
      .then(r => Promise.resolve(r.data))
      .catch(e => {
        if (e.response && e.response.status === 422) {
          return Promise.reject(e.response.data)
        } else {
          vomit(e)
        }
      })

  }
}

export default usersApi
