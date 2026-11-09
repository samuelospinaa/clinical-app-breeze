import './bootstrap'
import '../css/app.css'

import { createRoot, Root } from 'react-dom/client'
import { createInertiaApp } from '@inertiajs/react'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ChakraProvider } from '@chakra-ui/react'
import { CreateInertiaAppSetupReturnType } from '@inertiajs/inertia-react'
import GeneralContext from './Context/GeneralContext'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title: string): string => `${title} - ${appName}`,
  resolve: (name: string) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
  setup ({ el, App, props }: any): CreateInertiaAppSetupReturnType {
    const root: Root = createRoot(el)

    root.render(
      <ChakraProvider>
        <GeneralContext.GeneralProvider>
          <App {...props} />
        </GeneralContext.GeneralProvider>
      </ChakraProvider>
    )
  },
  progress: {
    color: '#4B5563'
  }
})
