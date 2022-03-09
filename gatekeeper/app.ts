import Fastify from "fastify"
import { APIError, apiErrorRoute } from "./src/api-error"
import DeepwellAPI from "./src/deepwell/deepwell"
import page from "./src/page"
import ping from "./src/ping"

// TODO: use HTTPs for production

const PROD = import.meta.env.PROD

const makeApp = async () => {
  const app = Fastify()

  DeepwellAPI.log = app.log

  app.setErrorHandler(async (error, request, reply) => {
    if (error instanceof APIError) {
      reply.code(error.code)
      reply.send({ error: error.type })
    } else {
      app.errorHandler(error, request, reply)
    }
    return reply
  })

  app.register(ping)
  app.register(apiErrorRoute)
  app.register(page)

  if (PROD) await app.listen(4000)

  return app
}

export const viteNodeApp = makeApp()
