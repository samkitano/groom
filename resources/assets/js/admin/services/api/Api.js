import swal from 'sweetalert2'

const apiBase = '/admin/api'

function vomit (e) {
  let msg = e.response.data.message ? `<p>${e.response.data.message}</p>` : ''
  msg += e.response.data.file ? `<p><strong>File: </strong>${e.response.data.file}</p>` : ''
  msg += e.response.data.line ? `<p><strong>Line: </strong>${e.response.data.line}</p>` : ''

  swal(e.message, msg, 'error').then(() => {})

  return Promise.reject(e)
}

function createBlob (blob, name = 'log.txt') {
  let downloadUrl = window.URL.createObjectURL(new Blob([blob]))
  let downloadLink = document.createElement('a')

  downloadLink.href = downloadUrl
  downloadLink.setAttribute('download', `laravel-log-${name}`)

  document.body.appendChild(downloadLink)

  downloadLink.click()

  return Promise.resolve(true)
}

function uuid () {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
    let r = Math.random() * 16 | 0, v = c == 'x'
      ? r
      : (r & 0x3 | 0x8)
    return v.toString(16)
  })
}

function normalizePayloadMethod (payload, method, force = false) {
  if (force && payload === undefined) {
    throw new Error(`Dude, we need a fucking payload!`)
  }

  if (!payload.hasOwnProperty('_method') || payload._method !== method) {
    payload._method = method
  }

  return payload
}

export { vomit, apiBase, createBlob, uuid, normalizePayloadMethod }
