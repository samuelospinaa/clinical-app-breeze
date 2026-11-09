import { JSX } from 'react'
import GuestLayout from '@/Layouts/GuestLayout'
import Titles from '@/Components/Common/UI/Titles'
import { Box, GridItem, Grid, Text, Image, Flex } from '@chakra-ui/react'
import Container from '@/Components/Common/UI/Container'
import portfolioImage from '../../../../public/images/portfolio/portfolio.webp'
import { Link } from '@inertiajs/react'

const Services = () => {
  return (<Box as="section" my={10}>
    <Container>
      <Box maxW="xl" mx="auto">
        <Titles title="Nuestros servicios"/>
      </Box>

      <Grid gridTemplateColumns={{ base: '1fr', md: 'repeat(2, 1fr)' }} gap={10} mt={10}>
        <GridItem w="100%">
          <Flex className="flex-col justify-around h-full">
            <Box>
              <Text mt={5}>
                En esta sección, explora la esencia de lo que ofrecemos a través de los testimonios de nuestros
                clientes en nuestro spa exclusivo.
              </Text>

              <Text my={5}>
                <strong>"Consiente tu cuerpo y alma"</strong> trasciende un simple lema; es la experiencia compartida
                por aquellos que han descubierto la transformación en nuestro santuario de serenidad. Descubre cómo
                nuestros tratamientos personalizados, ambiente sereno y un equipo de terapeutas excepcionales han
                dejado una impresión duradera en quienes nos eligen. Cada testimonio refleja la auténtica indulgencia y
                tranquilidad que ofrecemos.
              </Text>

              <Text>
                Sumérgete en estas historias de renovación y descubre por qué nuestros clientes eligen nuestros
                servicios para su bienestar integral.
              </Text>
            </Box>

            <Link href="/contacto" className="block">
              <button className="bg-principal text-white py-5 text-xl font-bold rounded-full w-full">
                Quiero una cita
              </button>
            </Link>
          </Flex>
        </GridItem>

        <GridItem w="100%">
          <Image alt="Brand Healthderma" src={portfolioImage} className="rounded-md"/>
        </GridItem>
      </Grid>
    </Container>
  </Box>)
}

Services.layout = (page: any): JSX.Element => <GuestLayout children={page} title="Nuestros servicios"/>

export default Services
