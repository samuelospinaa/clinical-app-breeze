import { Container as ContainerUI } from '@chakra-ui/react'
import { PropsWithChildren } from 'react'

const Container = ({ children }: PropsWithChildren) => {
  return (
    <ContainerUI maxW="7xl" mx="auto">
      {children}
    </ContainerUI>
  )
}

export default Container
