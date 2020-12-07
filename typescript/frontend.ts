import { request } from './lib/request'

import '../styles/frontend.scss'
import { XyResponseData, XyApiResponse, ResponseType } from './types'

/**
 * This file is built into an UMD bundle. The default export will
 * be exposed under window.myEmptyPlugin, if the resulting file is loaded via
 * <script> tag. You can also use modern import syntax to import the built file.
 */
export default (() => {
  const hello = async () => {
    console.log('Hello from myEmptyPlugin frontend.ts!')

    const response = await request<XyResponseData>('/xy', {
      method: 'GET',
    })

    const x: XyApiResponse = {
      ...response,
      kind: ResponseType.Xy, // Add the kind property to the RawApiResponse
    }

    console.log('Typed response', x)
    return x
  }

  hello()

  return {
    hello, // window.myEmptyPlugin.hello()
  }
})()
