import axios from 'axios'

const initMce = {
  plugins: 'code print preview searchreplace autolink visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
  toolbar1: 'styleselect | bold italic strikethrough | superscript subscript | forecolor backcolor | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | table | link | image media',
  toolbar2: 'undo redo | cut copy paste | code | removeformat | preview | fullscreen'
}

const httpSetup = function setup () {
  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

  let token = document.head.querySelector('meta[name="csrf-token"]')

  if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
  } else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
  }

  axios.interceptors.request.use((config) => {
    Bus.$emit('working', true)
    Bus.$emit('requesting', config.method)

    return config
  }, (error) => Promise.reject(error))

  axios.interceptors.response.use((response) => {
    Bus.$emit('working', false)
    Bus.$emit('requesting', '')

    return response
  }, (error) => Promise.reject(error))
}

export { initMce, httpSetup }
