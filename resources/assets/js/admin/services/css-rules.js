const rules = [
  {
    label: 'align-content',
    type: 'select',
    options: [
      'center',
      'flex-start',
      'flex-end',
      'space-between',
      'space-around',
      'stretch',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'align-items',
    type: 'select',
    options: [
      'baseline',
      'center',
      'flex-start',
      'flex-end',
      'stretch',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'align-self',
    type: 'select',
    options: [
      'auto',
      'baseline',
      'center',
      'flex-start',
      'flex-end',
      'stretch',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'background',
    type: 'text'
  },
  {
    label: 'background-attachment',
    type: 'select',
    options: ['fixed', 'inherit', 'initial', 'local', 'scroll', 'unset']
  },
  {
    label: 'background-clip',
    type: 'select',
    options: [
      'border-box',
      'padding-box',
      'content-box',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'background-color',
    type: 'color'
  },
  {
    label: 'background-image',
    type: 'text'
  },
  {
    label: 'background-origin',
    type: 'select',
    options: [
      'border-box',
      'padding-box',
      'content-box',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'background-position',
    type: 'text'
  },
  {
    label: 'background-repeat',
    type: 'select',
    options: ['inherit', 'initial', 'no-repeat', 'repeat', 'repeat-x', 'repeat-y', 'round', 'space', 'unset']
  },
  {
    label: 'background-size',
    type: 'select',
    options: [
      'auto',
      'cover',
      'contain',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'border',
    type: 'text'
  },
  {
    label: 'border-bottom',
    type: 'text'
  },
  {
    label: 'border-bottom-color',
    type: 'color'
  },
  {
    label: 'border-bottom-left-radius',
    type: 'text'
  },
  {
    label: 'border-bottom-right-radius',
    type: 'text'
  },
  {
    label: 'border-bottom-style',
    type: 'select',
    options: [
      'none',
      'hidden',
      'dotted',
      'dashed',
      'solid',
      'double',
      'groove',
      'ridge',
      'inset',
      'outset',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'border-bottom-width',
    type: 'text'
  },
  {
    label: 'border-color',
    type: 'color'
  },
  {
    label: 'border-left',
    type: 'text'
  },
  {
    label: 'border-left-color',
    type: 'color'
  },
  {
    label: 'border-left-style',
    type: 'select',
    options: [
      'none',
      'hidden',
      'dotted',
      'dashed',
      'solid',
      'double',
      'groove',
      'ridge',
      'inset',
      'outset',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'border-left-width',
    type: 'text'
  },
  {
    label: 'border-radius',
    type: 'text'
  },
  {
    label: 'border-right',
    type: 'text'
  },
  {
    label: 'border-right-color',
    type: 'color'
  },
  {
    label: 'border-right-style',
    type: 'select',
    options: [
      'none',
      'hidden',
      'dotted',
      'dashed',
      'solid',
      'double',
      'groove',
      'ridge',
      'inset',
      'outset',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'border-right-width',
    type: 'text'
  },
  {
    label: 'border-top',
    type: 'text'
  },
  {
    label: 'border-top-color',
    type: 'color'
  },
  {
    label: 'border-top-left-radius',
    type: 'text'
  },
  {
    label: 'border-top-right-radius',
    type: 'text'
  },
  {
    label: 'border-top-style',
    type: 'select',
    options: [
      'none',
      'hidden',
      'dotted',
      'dashed',
      'solid',
      'double',
      'groove',
      'ridge',
      'inset',
      'outset',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'border-top-width',
    type: 'text'
  },
  {
    label: 'bottom',
    type: 'text'
  },
  {
    label: 'color',
    type: 'color'
  },
  {
    label: 'cursor',
    type: 'select',
    options: [
      'alias',
      'all-scroll',
      'auto',
      'cell',
      'col-resize',
      'context-menu',
      'copy',
      'crosshair',
      'default',
      'grab',
      'grabbing',
      'help',
      'inherit',
      'initial',
      'move',
      'n-resize',
      'ne-resize',
      'nesw-resize',
      'no-drop',
      'none',
      'not-allowed',
      'ns-resize',
      'nw-resize',
      'nwse-resize',
      'pointer',
      'progress',
      'row-resize',
      's-resize',
      'se-resize',
      'sw-resize',
      'text',
      'unset',
      'vertical-text',
      'w-resize',
      'wait',
      'zoom-in',
      'zoom-out'
    ]
  },
  {
    label: 'display',
    type: 'select',
    options: [
      'block',
      'contents',
      'flex',
      'flow-root',
      'grid',
      'inherit',
      'initial',
      'inline',
      'inline-block',
      'inline-flex',
      'inline-grid',
      'inline-table',
      'list-item',
      'none',
      'table',
      'table-caption',
      'table-cell',
      'table-column',
      'table-row',
      'unset'
    ]
  },
  {
    label: 'flex',
    type: 'text',
    options: [
      'none',
      'auto',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-basis',
    type: 'text',
    options: [
      'auto',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-direction',
    type: 'select',
    options: [
      'row',
      'row-reverse',
      'column',
      'column-reverse',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-flow',
    type: 'text',
    options: [
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-grow',
    type: 'text',
    options: [
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-shrink',
    type: 'text',
    options: [
      'initial',
      'inherit'
    ]
  },
  {
    label: 'flex-wrap',
    type: 'select',
    options: [
      'nowrap',
      'wrap',
      'wrap-reverse',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'float',
    type: 'select',
    options: [
      'inherit',
      'initial',
      'inline-end',
      'inline-start',
      'left',
      'none',
      'right',
      'unset'
    ]
  },
  {
    label: 'font-family',
    type: 'text'
  },
  {
    label: 'font-size',
    type: 'text'
  },
  {
    label: 'font-style',
    type: 'select',
    options: [
      'inherit',
      'initial',
      'italic',
      'normal',
      'oblique',
      'unset'
    ]
  },
  {
    label: 'font-variant',
    type: 'select',
    options: [
      'full-width',
      'inherit',
      'initial',
      'normal',
      'ordinal',
      'ruby',
      'simplified',
      'small-caps',
      'sub',
      'super'
    ]
  },
  {
    label: 'font-weight',
    type: 'text'
  },
  {
    label: 'height',
    type: 'text'
  },
  {
    label: 'justify-content',
    type: 'select',
    options: [
      'flex-start',
      'flex-end',
      'center',
      'space-between',
      'space-around',
      'initial',
      'inherit'
    ]
  },
  {
    label: 'left',
    type: 'text'
  },
  {
    label: 'letter-spacing',
    type: 'text'
  },
  {
    label: 'line-break',
    type: 'select',
    options: [
      'auto',
      'inherit',
      'initial',
      'loose',
      'normal',
      'strict',
      'unset'
    ]
  },
  {
    label: 'line-height',
    type: 'text'
  },
  {
    label: 'list-style',
    type: 'select',
    options: [
      'inherit',
      'initial',
      'inside',
      'none',
      'outside',
      'unset'
    ]
  },
  {
    label: 'list-style-type',
    type: 'select',
    options: [
      'disc',
      'circle',
      'square',
      'decimal',
      'georgian',
      'inherit',
      'initial',
      'cjk-ideographic',
      'kannada',
      'none',
      'unset'
    ]
  },
  {
    label: 'margin',
    type: 'text'
  },
  {
    label: 'margin-bottom',
    type: 'text'
  },
  {
    label: 'margin-left',
    type: 'text'
  },
  {
    label: 'margin-right',
    type: 'text'
  },
  {
    label: 'margin-top',
    type: 'text'
  },
  {
    label: 'max-height',
    type: 'text'
  },
  {
    label: 'max-width',
    type: 'text'
  },
  {
    label: 'min-height',
    type: 'text'
  },
  {
    label: 'min-width',
    type: 'text'
  },
  {
    label: 'opacity',
    type: 'number'
  },
  {
    label: 'order',
    type: 'text',
    options: [
      'inherit',
      'initial'
    ]
  },
  {
    label: 'outline',
    type: 'text'
  },
  {
    label: 'outline-color',
    type: 'color'
  },
  {
    label: 'outline-style',
    type: 'select',
    options: [
      'auto',
      'dashed',
      'dotted',
      'double',
      'groove',
      'inherit',
      'initial',
      'inset',
      'none',
      'outset',
      'ridge',
      'solid',
      'unset'
    ]
  },
  {
    label: 'outline-width',
    type: 'text'
  },
  {
    label: 'outline-offset',
    type: 'select',
    options: [
      'calc',
      'inherit',
      'initial',
      'unset'
    ]
  },
  {
    label: 'overflow',
    type: 'select',
    options: [
      'auto',
      'hidden',
      'inherit',
      'initial',
      'scroll',
      'unset',
      'visible'
    ]
  },
  {
    label: 'overflow-x',
    type: 'select',
    options: [
      'auto',
      'hidden',
      'inherit',
      'initial',
      'scroll',
      'unset',
      'visible'
    ]
  },
  {
    label: 'overflow-y',
    type: 'select',
    options: [
      'auto',
      'hidden',
      'inherit',
      'initial',
      'scroll',
      'unset',
      'visible'
    ]
  },
  {
    label: 'padding',
    type: 'text'
  },
  {
    label: 'padding-bottom',
    type: 'text'
  },
  {
    label: 'padding-left',
    type: 'text'
  },
  {
    label: 'padding-right',
    type: 'text'
  },
  {
    label: 'padding-top',
    type: 'text'
  },
  {
    label: 'position',
    type: 'select',
    options: [
      'absolute',
      'fixed',
      'inherit',
      'initial',
      'relative',
      'static',
      'sticky',
      'unset'
    ]
  },
  {
    label: 'right',
    type: 'text'
  },
  {
    label: 'text-align',
    type: 'select',
    options: [
      'center',
      'end',
      'inherit',
      'initial',
      'justify',
      'left',
      'match-parent',
      'right',
      'start',
      'unset'
    ]
  },
  {
    label: 'text-decoration',
    type: 'select',
    options: [
      'blink',
      'inherit',
      'initial',
      'line-through',
      'none',
      'overline',
      'overline wavy',
      'underline',
      'underline wavy',
      'unset'
    ]
  },
  {
    label: 'text-decoration-color',
    type: 'color'
  },
  {
    label: 'text-indent',
    type: 'text'
  },
  {
    label: 'text-justify',
    type: 'select',
    options: [
      'auto',
      'distribute',
      'inherit',
      'initial',
      'inter-character',
      'inter-word',
      'none',
      'unset'
    ]
  },
  {
    label: 'text-overflow',
    type: 'select',
    options: [
      'clip',
      'elipsis',
      'inherit',
      'initial',
      'unset'
    ]
  },
  {
    label: 'text-shadow',
    type: 'text'
  },
  {
    label: 'text-transform',
    type: 'select',
    options: [
      'capitalize',
      'full-width',
      'inherit',
      'initial',
      'lowercase',
      'none',
      'unset',
      'uppercase'
    ]
  },
  {
    label: 'top',
    type: 'text'
  },
  {
    label: 'vertical-align',
    type: 'select',
    options: [
      'baseline',
      'bottom',
      'calc',
      'inherit',
      'initial',
      'middle',
      'sub',
      'super',
      'text-bottom',
      'text-top',
      'top',
      'unset'
    ]
  },
  {
    label: 'visibility',
    type: 'select',
    options: [
      'collapse',
      'hidden',
      'inherit',
      'initial',
      'unset',
      'visible'
    ]
  },
  {
    label: 'white-space',
    type: 'select',
    options: [
      'inherit',
      'initial',
      'normal',
      'nowrap',
      'pre',
      'pre-line',
      'pre-wrap',
      'unset'
    ]
  },
  {
    label: 'width',
    type: 'text'
  },
  {
    label: 'word-break',
    type: 'select',
    options: [
      'break-all',
      'inherit',
      'initial',
      'keep-all',
      'normal',
      'unset'
    ]
  },
  {
    label: 'word-spacing',
    type: 'select',
    options: [
      'calc',
      'inherit',
      'initial',
      'normal',
      'unset'
    ]
  },
  {
    label: 'word-wrap',
    type: 'select',
    options: [
      'break-word',
      'inherit',
      'initial',
      'normal',
      'unset'
    ]
  },
  {
    label: 'z-index',
    type: 'number'
  },
  {
    label: 'zoom',
    type: 'text'
  }
]

export default rules
