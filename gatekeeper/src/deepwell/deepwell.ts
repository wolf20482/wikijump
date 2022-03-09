import type { FastifyLoggerInstance } from "fastify"
import { GotClient } from "./got-client"
import type { LocaleOutput, Page } from "./types"

export class DeepwellAPI extends GotClient {
  /** Logger for the API.
   *
   * **MUST BE SET BEFORE USAGE OF THE API.**
   */
  declare log: FastifyLoggerInstance

  async parseLocale(locale: string) {
    return await this.get(`locale/${locale}`).json<LocaleOutput>()
  }

  async translate(locale: string, key: string, values: Record<string, string> = {}) {
    return await this.get(`message/${locale}/${key}`, { json: values }).json<string>()
  }

  async getPage(site: number | null, id: number | string, opts: GetPageOpts = {}) {
    if (site === null && typeof id === "string") {
      throw new Error("Site must be specified for slugs")
    }

    const { wikitext = false, html = false } = opts

    const path =
      site === null
        ? `page/direct/${id}`
        : typeof id === "number"
        ? `page/${site}/id/${id}`
        : `page/${site}/slug/${id}`

    const res = await this.try.get<Page>(path, { searchParams: { wikitext, html } })

    if (res.ok) {
      return res.response.body
    } else {
      this.log.warn(`Page not found: '${path}'`)
      return null
    }
  }
}

export default new DeepwellAPI()

export interface GetPageOpts {
  wikitext?: boolean
  html?: boolean
}
