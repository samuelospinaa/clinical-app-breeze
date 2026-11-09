import { Box, Flex, Image, Text } from '@chakra-ui/react'
import { SECONDARY_BG_COLOR } from '@/Components/Common/variables'
import Brand from '../../../../../../public/images/logo.webp'
import MobileMenu from '@/Layouts/GuestLayout/Header/SubComponents/MobileMenu'
import { Link } from '@inertiajs/react'

const FirstHeader = () => {
  return (
    <Box bg={{ base: 'white', md: SECONDARY_BG_COLOR }} p={3} className="shadow-sm shadow-black-50/30">
      <Flex justifyContent="space-between" alignItems="center" maxW="7xl" mx="auto">
        <Image w={200} alt="Brand LateCorazon" src={Brand} className="block md:hidden"/>

        <Box className="w-full justify-between items-center hidden md:flex">
          <Text>Realza la belleza de tu cuerpo y alma. Permítenos guiarte en este proceso.</Text>

          <Link href="/contacto">
            <button className="py-3 px-5 font-bold uppercase bg-principal text-white rounded-full">
              Quiero una cita
            </button>
          </Link>
        </Box>

        <Box className="block md:hidden">
          <MobileMenu/>
        </Box>
      </Flex>
    </Box>
  )
}

export default FirstHeader
