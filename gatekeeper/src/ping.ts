import type { FastifyInstance } from "fastify"

export default async function ping(fastify: FastifyInstance) {
  fastify.get("/ping", async (request, reply) => {
    reply.send({ message: "pong" })
  })
}
