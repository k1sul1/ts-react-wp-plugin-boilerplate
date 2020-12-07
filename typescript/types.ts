declare global {
  interface Window {
    // This comes from WordPress
    myEmptyPlugin: LocalizeData

    // Some WP globals that we don't have types for
    jQuery: any // WP uses 1.12.4, there's no @types/jquery@1.12.4
    // _: any, // @types/underscore@1.8.3
    wp: any
  }
}

export interface LocalizeData {
  backendUrl: string
  i18n: Record<string, string>
  adminUrl?: string
  post?: { ID: string; [k: string]: any } // We only care about the ID
  requestHeaders?: {
    'X-WP-Nonce': string
    [k: string]: any
  }
}

export interface RawApiResponse<DataType> {
  headers: Headers
  status: number
  statusText: string
  url: string
  ok: boolean
  data: DataType
}

// Here's the fun stuff. API response types!

// Let's start with an enum of all our responses. We could use strings directly, but TS helps us more when we don't.

export enum ResponseType {
  Xy = 'xy',
  Xyz = 'xyz',
  ApiError = 'apiError',
}

// These responses are pretty much the same, but there's one discriminating property: kind
// This helps us define the actual response types with less verbosity.
export type ApiResponse<
  TKind extends ResponseType,
  TData
> = RawApiResponse<TData> & { kind: TKind }

// This is what the data portion of an errored api response looks like:
export interface ApiError<T = any> {
  error: string
  data: T
}

export type XyResponseData = ApiError | { data: { something: boolean } }
export type XyApiResponse = ApiResponse<ResponseType.Xy, XyResponseData>

// The Xyz endpoint can only return errors because it was built to do so. As such, the types match that.
export type XyzResponseData = ApiError<{ 'git gud': string }>
export type XyzApiResponse = ApiResponse<ResponseType.Xyz, XyzResponseData>

// For sake of completeness:
export type ApiErrorApiResponse = ApiResponse<ResponseType.ApiError, ApiError>

export type GenericApiResponse =  // Add into this union as you add new responses and types
  | XyApiResponse
  | XyzApiResponse
  | ApiErrorApiResponse
