import { JSX } from 'react'
import GuestLayout from '@/Layouts/GuestLayout'
import { Box, Grid, GridItem, Text } from '@chakra-ui/react'
import Titles from '@/Components/Common/UI/Titles'
import Testimony from '@/Components/Home/Testimonies/SubComponents/Testimony'
import Container from '@/Components/Common/UI/Container'

const Testimonies = ({ testimonies = [] }: { testimonies: any[] }) => {
  return (
    <Box as="section" my={10}>
      <Container>
        <Box maxW="xl" mx="auto">
          <Titles title="Lo que hablan nuestos pacientes"/>
        </Box>

        <Text textAlign="center" mt={5} maxW="4xl" mx="auto">
          En esta sección, descubre lo que dicen nuestros clientes sobre su experiencia en nuestro spa exclusivo.
          "Consiente tu cuerpo y alma" va más allá de un lema; es la realidad que comparten aquellos que han vivido la
          transformación en nuestro santuario de serenidad. Explora los testimonios que destacan tratamientos
          personalizados, un ambiente sereno y un equipo de terapeutas excepcionales. Cada palabra refleja la
          verdadera indulgencia y tranquilidad que ofrecemos. Sumérgete en las historias de renovación y descubre por
          qué nuestros clientes eligen nuestro spa como su refugio de bienestar.
        </Text>

        <Grid gridTemplateColumns={{ base: '1fr', md: 'repeat(3, 1fr)' }} gap={10} mt={10}>
          {testimonies.map((testimony: any, idx: number) => (
            <GridItem key={idx} w="100%">
              <Testimony testimony={testimony}/>
            </GridItem>
          ))}
        </Grid>
      </Container>
    </Box>
  )
}

Testimonies.layout = (page: any): JSX.Element => <GuestLayout children={page} title="Testimonios"/>

export default Testimonies
