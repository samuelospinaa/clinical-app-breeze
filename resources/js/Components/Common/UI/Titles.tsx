import { Flex, Heading } from '@chakra-ui/react'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'
import LottusIcon from '@/Components/Common/UI/Assets/LottusIcon'

const Titles = ({ title, letterColor }: {title: string, letterColor?: string}) => {
  return (
    <Flex alignItems="center" flexDirection="column">
      <Heading size="3xl" textAlign="center" color={letterColor}>{title}</Heading>
      <LottusIcon size={35} color={PRINCIPAL_COLOR}/>
    </Flex>
  )
}

export default Titles
