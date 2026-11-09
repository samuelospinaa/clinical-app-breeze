import { Box, Flex, Image, List, Text } from '@chakra-ui/react'
import { ItemNav } from '../styles'
import { FaUserCircle } from 'react-icons/fa'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'
import { Link } from '@inertiajs/react'
import { navigation } from '@/Layouts/GuestLayout/config'
import Brand from '../../../../../../public/images/logo.webp'

const NavMenu = ({ isMobile }: { isMobile?: boolean }) => {
  return (
    <Flex as="nav" position="relative" alignItems="center" justifyContent="space-between" maxW="7xl" mx="auto" flexDir={isMobile ? 'column' : 'row'}>
      <Box as="section" id="brand" bg="white" py={7}>
        <Image w={250} className="mx-auto" alt="Brand Healthderma" src={Brand}/>
      </Box>

      <Flex alignItems="center" flexDir={isMobile ? 'column' : 'row'}>
        <List
          display="flex"
          flexDir={isMobile ? 'column' : 'row'}
          width={{ base: 'full', md: 'auto' }}
          alignItems="center"
          justifyContent="center"
          padding={6}
          bg="white"
          color="black"
        >
          {navigation.map((item: any, idx: number) => (
            <ItemNav key={idx}>
              <Link href={route(item.url)} aria-current={route().current(item.url) ? 'page' : false}>
                <Text fontSize="md">{item.name}</Text>
              </Link>
            </ItemNav>
          ))}
        </List>

        <Box>
          <a href={route('filament.admin.pages.dashboard')}>
            <FaUserCircle size={25} color={PRINCIPAL_COLOR}/>
          </a>
        </Box>
      </Flex>
    </Flex>
  )
}

export default NavMenu
