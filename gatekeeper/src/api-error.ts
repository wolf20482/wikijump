import type { FastifyInstance, FastifyReply } from "fastify"

export const APIErrors = {
  "BAD_SYNTAX": 400
} as const

export function APIError(reply: FastifyReply, error: keyof typeof APIErrors) {
  reply.code(APIErrors[error]).type("application/json").send({ error })
  return reply
}

export async function apiErrorRoute(fastify: FastifyInstance) {
  fastify.get("/error", async (request, reply) => {
    // throw a random error from the APIErrors object
    const key =
      Object.keys(APIErrors)[Math.floor(Math.random() * Object.keys(APIErrors).length)]
    return APIError(reply, key as any)
  })
}
