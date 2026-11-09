import { Box, Flex, Grid, GridItem, Heading, Image, Text } from '@chakra-ui/react'
import Container from '@/Components/Common/UI/Container'
import WhiteBrand from '../../../../../public/images/logo_blanco.webp'
import { BoxFooter } from '@/Layouts/GuestLayout/styles'
import Social from '@/Layouts/GuestLayout/Footer/SubComponents/Social'
import { FaLocationDot } from 'react-icons/fa6'
import { FaEnvelope, FaPhoneAlt } from 'react-icons/fa'
import { navigation } from '@/Layouts/GuestLayout/config'
import { Link } from '@inertiajs/react'

const Footer = () => {
  return (<>
      <BoxFooter>
        <Container>
          <Grid gridTemplateColumns={{ base: '1fr', md: 'repeat(3, 1fr)' }} gap={10}>
            <GridItem w="100%">
              <Image w={300} alt="Brand Healthderma" src={WhiteBrand}/>

              <Text mt={5} color="#ccc">
                Puedes encontrarnos en la Cra 43A #1Sur - 50 El Poblado 🏢 Edificio: Cross Business Center Of 505 (al
                lado del Hotel San Fernando Plaza). Estamos disponibles para atenderte de lunes a viernes, de 7 am a 6
                pm, y los sábados de 8 am a 12 m. No dudes en reservar una cita gratuita para una valoración
                personalizada y un plan de tratamiento adaptado a tus necesidades.
              </Text>

              <Social/>
            </GridItem>

            <GridItem display="flex" flexDir="column" alignItems="flex-start" gap={6} maxW="xl" pl={5} fontSize="17px">
              <Heading color="#fff" textAlign="center" w="100%" size="lg">Contáctenos</Heading>

              <Flex alignItems="center" gap={5} color="#fff">
                <Box bg={'#3d4343'} p={4} borderRadius="100%">
                  <FaLocationDot/>
                </Box>
                <Text>Cra 43A #1Sur - 50 El Poblado <br/> Edificio: Cross Business Center Of 505</Text>
              </Flex>

              <Flex alignItems="center" gap={5} color="#fff">
                <Box bg={'#3d4343'} p={4} borderRadius="100%">
                  <FaPhoneAlt/>
                </Box>
                <Text>+57 (317) 566 5610 <br/> (604) 444 44 44</Text>
              </Flex>

              <Flex alignItems="center" gap={5} color="#fff">
                <Box bg={'#3d4343'} p={4} borderRadius="100%">
                  <FaEnvelope/>
                </Box>
                <Text>info@healthderma.com</Text>
              </Flex>
            </GridItem>

            <GridItem w="100%">
              <Heading color="#fff" textAlign="center" w="100%" mb={5} size="lg">Enlaces rápidos</Heading>

              {navigation.map((item: any, idx: number) => (
                <Link key={idx} href={route(item.url)} aria-current={route().current(item.url) ? 'page' : false}>
                  <Box bg={'#3d4343'} p={4} color="#fff" my={3}>
                    {item.name}
                  </Box>
                </Link>))}
            </GridItem>
          </Grid>
        </Container>
      </BoxFooter>

      <iframe src="https://ecovedigital.com/credits" name="ecoveCredits" scrolling="no" frameBorder="1"
              marginHeight={0} marginWidth={0} width="100%" allowFullScreen height="40px"/>
    </>)
}

export default Footer
