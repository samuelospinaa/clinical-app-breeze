import { createStandaloneToast } from '@chakra-ui/react'

const { toast } = createStandaloneToast()

export const sendSuccessMessage = () => toast({
  title: 'Recibido!!',
  description: 'Hemos recibido tu mensaje!!',
  status: 'success',
  duration: 9000,
  isClosable: true
})
