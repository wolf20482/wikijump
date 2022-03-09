import Fastify from "fastify"
import { apiErrorRoute } from "./src/api-error"
import DeepwellAPI from "./src/deepwell/deepwell"
import ping from "./src/ping"

const makeApp = async () => {
  const app = Fastify()

  DeepwellAPI.log = app.log

  app.register(ping)
  app.register(apiErrorRoute)

  if (import.meta.env.PROD) {
    app.listen(4000)
  }

  return app
}

export const viteNodeApp = makeApp()
