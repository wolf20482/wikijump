import got, {
  HTTPError,
  Options,
  RequestError,
  type CancelableRequest,
  type Response,
  type OptionsOfJSONResponseBody
} from "got"

export class GotClient {
  private readonly gotDefaults = new Options({
    prefixUrl: import.meta.env.PROD
      ? "http://api:2747/api/vI/"
      : "http://localhost:2747/api/vI/",
    // TODO: timeout:
    responseType: "json",
    headers: {
      "User-Agent": "wikijump-gatekeeper"
      // TODO: "X-Exempt-RateLimit":
    }
  })

  private readonly gotInstance: typeof got

  protected declare try: {
    [P in keyof Pick<
      GotClient,
      "post" | "get" | "put" | "patch" | "delete" | "head"
    >]: GotClient[P] extends (...args: infer A) => CancelableRequest<Response<any>>
      ? <R = unknown>(...args: A) => Promise<RequestResult<R>>
      : never
  }

  constructor() {
    this.gotInstance = got.extend(this.gotDefaults)

    // @ts-ignore
    this.try = new Proxy(this, {
      get: (target, key, receiver) => {
        if (key in GotClient.prototype) {
          return (...args: any[]) => {
            try {
              // @ts-ignore
              const res = await this[key](...args)
              return new RequestResult(res)
            } catch (error: unknown) {
              if (error instanceof RequestError) {
                return new RequestResult(error)
              } else {
                throw error
              }
            }
          }
        } else {
          throw new Error("Unknown method")
        }
      }
    })
  }

  post<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.post<T>(path, options)
  }

  get<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.get<T>(path, options)
  }

  put<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.put<T>(path, options)
  }

  delete<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.delete<T>(path, options)
  }

  patch<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.patch<T>(path, options)
  }

  head<T = unknown>(path: string, options?: OptionsOfJSONResponseBody) {
    return this.gotInstance.head<T>(path, options)
  }

  statusFromError(error: unknown) {
    if (error instanceof HTTPError) {
      return error.response.statusCode
    }

    return null
  }
}

export class RequestResult<T> {
  /** Internally holds the error object. */
  private declare _error?: RequestError

  /** Internally holds the result object. */
  private declare _response?: Response<T>

  /**
   * True if the {@link response} property will contain the response. Will be false if
   * the {@link error} property will contain an error.
   */
  declare readonly ok: boolean

  /** @param result - The response or error of a response. */
  constructor(result: Response<T> | RequestError) {
    if (result instanceof Error) {
      this._error = result
      this.ok = false
    } else {
      this._response = result
      this.ok = true
    }
  }

  /**
   * The request's error. Will cause an error to be thrown if the result
   * wasn't an error.
   */
  get error() {
    if (this.ok) throw new Error("Result is not an error")
    return this._error!
  }

  /**
   * The request's response. Will cause an error to be thrown if the API
   * request failed.
   */
  get response() {
    if (!this.ok) throw new Error("Result is not ok")
    return this._response!
  }

  /** Returns the {@link response} or `null` if the request was an error. */
  unwrapOrNull() {
    return this.ok ? this.response : null
  }
}
