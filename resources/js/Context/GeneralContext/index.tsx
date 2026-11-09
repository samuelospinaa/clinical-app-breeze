import { createContext, useEffect, useMemo, useReducer } from 'react'
import { generalReducer, InitialState } from './reducers'
import { setIsMobile } from './actions'

export const GeneralContext: any = createContext<any>(InitialState)

const GeneralProvider = ({ children }: any) => {
  const [state, dispatch]: any = useReducer<any>(generalReducer, InitialState)

  useEffect(() => {
    const handleResize = () => {
      dispatch(setIsMobile(window.innerWidth < 768))
    }

    handleResize()

    window.addEventListener('resize', handleResize)

    return () => {
      window.removeEventListener('resize', handleResize)
    }
  }, [])

  const context = useMemo(() => ({
    isMobile: state.isMobile
  }), [state])

  return (
      <GeneralContext.Provider value={context}>
         {children}
      </GeneralContext.Provider>
  )
}

export default {
  GeneralProvider,
  Consumer: GeneralContext.Consumer
}
