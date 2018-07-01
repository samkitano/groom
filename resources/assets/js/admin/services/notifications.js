import swal from 'sweetalert2'

function swalError (title = 'ERROR', html) {
  return swal({
    title,
    html,
    type: 'error',
    animation: false,
    customClass: 'animated zoomInDown'
  })
}

function swalSuccess (title = 'SUCCESS!', html) {
  return swal({
    title,
    html,
    type: 'success',
    animation: false,
    customClass: 'animated zoomInDown'
  })
}

const alertConfirm = function (html) {
  return swal({
    title: 'PLEASE CONFIRM',
    html,
    confirmButtonColor: '#d33',
    confirmButtonText: 'I CONFIRM',
    showCancelButton: true,
    focusCancel: true,
    type: 'warning',
    animation: false,
    customClass: 'animated zoomInDown'
  }).then((go) => {
    return Promise.resolve(!!go.value)
  })
}

const noDelHomePage = function () {
  return swalError('WTF!!!', '<br>You want to Delete the HOME page???<br><h3>LOL! NO!</h3><br> Mes coulles...')
}

const alertSuccess = function (title, html) {
  if (html === undefined) {
    html = title
    title = undefined
  }

  return swalSuccess(title, html)
}

const alertError = function (msg) {
  return swalError('ERROR', msg)
}

export {
  alertConfirm,
  alertSuccess,
  alertError,
  noDelHomePage
}
