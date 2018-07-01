import alerts from './alerts'
import mutations from './mutations'
import * as actions from './actions'

export default function () {
  return {
    actions,
    mutations,
    state: {
      alerts,
      appName: '',
      baseDir: '',
      canSaveBtn: false,
      count: false,
      editingName: false,
      langs: ['en', 'pt', 'fr'],
      loaded: false,
      more: {
        en: 'Learn more',
        pt: 'Saiba mais',
        fr: 'Savoir plus'
      },
      requesting: '',
      shownAlerts: [],
      user: {},
      working: false
    }
  }
}
