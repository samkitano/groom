/** global $ */

'use strict'

import $ from 'jquery'
import { Elastic } from 'gsap/EasePack'
import TweenLite from 'gsap/TweenLite'

require('gsap/CSSPlugin')

let $selector = $('#lang_trigger')

$(document).click(function () {
  if ($selector.hasClass('open')) {
    closeLangSelector()
  }
})

$('.lang-trigger').on('click', function (e) {
  e.stopPropagation()
  e.preventDefault()

  if ($(this).hasClass('open')) {
    closeLangSelector()
  } else {
    openLangSelector()
  }
})

function openLangSelector () {
  TweenLite.to('#lang_selector', 0.8, { x: -135, ease: Elastic.easeOut.config(1, 0.3) })
  $selector.addClass('open')
}

function closeLangSelector () {
  TweenLite.to('#lang_selector', 0.8, { x: 0, ease: Elastic.easeOut.config(1, 0.3) })
  $selector.removeClass('open')
}
