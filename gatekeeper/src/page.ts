import type { FastifyInstance } from "fastify"
import type { RouteGenericInterface } from "fastify/types/route"
import { APIError } from "./api-error"
import DeepwellAPI from "./deepwell/deepwell"

export interface PageRequest extends RouteGenericInterface {
  Params: { path_type: "id" | "slug"; path: string }
}

export default async function page(fastify: FastifyInstance) {
  fastify.get<PageRequest>("/page/:path_type/:path", {
    schema: {
      params: {
        path_type: { type: "string", enum: ["id", "slug"] },
        path: { type: "string" }
      }
    },
    handler: async (request, reply) => {
      const { path_type, path } = request.params
      const id = path_type === "id" ? parseInt(path, 10) : path
      const page = await DeepwellAPI.getPage(1, id) // TODO: hardcoded site ID

      if (page === null) throw new APIError("PAGE_NOT_FOUND")

      return page
    }
  })
}
