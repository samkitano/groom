export const setUser = ({ commit }, usr) => {
  commit('SET_USER', usr)
}

export const setApp = ({ commit }, setts) => {
  commit('SET_APP', setts)
}

export const unSetUser = ({ commit }) => {
  commit('SET_USER', {})
}

export const setLoaded = ({ commit }) => {
  commit('SET_LOADED', true)
}

export const unSetLoaded = ({ commit }) => {
  commit('SET_LOADED', false)
}

export const setCount = ({ commit }, number) => {
  commit('SET_COUNT', number)
}

export const unSetCount = ({ commit }) => {
  commit('SET_COUNT', false)
}

export const setEditingName = ({ commit }, str) => {
  commit('SET_EDITING_NAME', str)
}

export const unSetEditingName = ({ commit }) => {
  commit('SET_EDITING_NAME', false)
}

export const toggleAlert = ({ commit }, str) => {
  commit('TOGGLE_ALERT', str)
}

export const setCanSaveBtn = ({ commit }, boolVal) => {
  commit('SET_CAN_SAVE_BTN', boolVal)
}

export const setWorking = ({ commit }) => {
  commit('SET_WORKING', true)
}

export const unSetWorking = ({ commit }) => {
  commit('SET_WORKING', false)
}

export const setRequesting = ({ commit }, str) => {
  commit('SET_REQUESTING', str)
}
