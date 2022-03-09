import Fastify from "fastify"
import DeepwellAPI from "./src/deepwell/deepwell"
import ping from "./src/ping"

const makeApp = async () => {
  const app = Fastify()

  DeepwellAPI.log = app.log

  app.register(ping)

  if (import.meta.env.PROD) {
    app.listen(4000)
  }

  return app
}

export const viteNodeApp = makeApp()
