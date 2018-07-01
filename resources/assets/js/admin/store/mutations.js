const mutations = {
  SET_USER (state, user) {
    state.user = user
  },

  SET_LOADED (state, boolVal) {
    state.loaded = boolVal
  },

  SET_COUNT (state, count) {
    state.count = count
  },

  SET_EDITING_NAME (state, editingName) {
    state.editingName = editingName
  },

  SET_CAN_SAVE_BTN (state, stt) {
    state.canSaveBtn = stt
  },

  SET_APP (state, setts) {
    state.appName = setts.appName
    state.baseDir = setts.baseDir
  },

  SET_WORKING (state, boolVal) {
    state.working = boolVal
  },

  SET_REQUESTING (state, str) {
    state.requesting = str
  }
}

export default mutations
