import ReactDOMServer from 'react-dom/server'
import { createInertiaApp } from '@inertiajs/react'
import createServer from '@inertiajs/react/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import route from '../../vendor/tightenco/ziggy/dist/index.m'
import { ReactInstance } from '@inertiajs/inertia-react'
import { ChakraProvider } from '@chakra-ui/react'
import GeneralContext from './Context/GeneralContext'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createServer((page: any) =>
  createInertiaApp({
    page,
    render: ReactDOMServer.renderToString,
    title: (title: string): string => `${title} - ${appName}`,
    resolve: (name: string) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup: ({ App, props }: any): ReactInstance => {
      // @ts-ignore
      global.route = (name: any, params: any, absolute: any) =>
        route(name, params, absolute, {
          ...page.props.ziggy,
          location: new URL(page.props.ziggy.location)
        })

      return (
        <ChakraProvider>
          <GeneralContext.GeneralProvider>
            <App {...props} />
          </GeneralContext.GeneralProvider>
        </ChakraProvider>
      )
    }
  }), 13715
)
