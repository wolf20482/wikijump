import type { FastifyInstance, FastifyReply } from "fastify"

export const APIErrors = {
  "BAD_SYNTAX": 400,
  "PAGE_NOT_FOUND": 404
} as const

export class APIError extends Error {
  declare code: number
  declare type: string

  constructor(error: keyof typeof APIErrors) {
    super()
    this.code = APIErrors[error]
    this.type = error
  }
}

export async function apiErrorRoute(fastify: FastifyInstance) {
  fastify.get("/error", async (request, reply) => {
    // throw a random error from the APIErrors object
    const key =
      Object.keys(APIErrors)[Math.floor(Math.random() * Object.keys(APIErrors).length)]
    throw new APIError(key as any)
  })
}
