import { LocalizeData } from '../types'

/**
 * Take data from wp_localize_script and assign it into a module.
 */
export default ((window): LocalizeData =>
  Object.assign(
    {
      backendUrl: null,
      requestHeaders: {
        'X-WP-Nonce': null,
      },
      post: null,
      i18n: {
        // This list is bound to change so frequently that there's no point in including any defaults.
      },
    },
    window.myEmptyPlugin
  ))(window)
