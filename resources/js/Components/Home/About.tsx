import { Avatar, Box, Flex, Grid, GridItem, Heading, Image, Text } from '@chakra-ui/react'
import ImageAbout from '../../../../public/images/Home/about.webp'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'
import Titles from '@/Components/Common/UI/Titles'

const About = () => {
  return (<Box as="section" mt={{ base: 0, md: 20 }}>
      <Grid gridTemplateColumns={{ base: '1fr', md: 'repeat(2, 1fr)' }} gap={10}>
        <GridItem w="100%" mt={{ base: 10, md: 0 }} px={5}>
          <Titles title="Acerca de nosotros."/>

          <Text mt={2}>
            Somos un centro estético especializado en brindar tratamientos avanzados y personalizados para realzar la
            belleza natural de nuestros clientes. En HealthDerma, nuestro principal objetivo es proporcionar una
            experiencia de bienestar inigualable, donde cada persona se sienta cuidada, consentida y segura.
          </Text>

          <Text mt={5}>
            En HealthDerma, ofrecemos una amplia gama de tratamientos, desde protocolos de reducción y tonificación
            corporal, limpiezas faciales profundas y porcelanización facial, hasta procedimientos médicos como
            aplicaciones de toxina botulínica y relleno con ácido hialurónico. Cada servicio está diseñado para
            brindarte resultados sorprendentes y duraderos.
          </Text>

          <Text mt={5}>
            En HealthDerma, no solo somos un centro estético; somos tu aliado en el camino hacia una versión mejorada y
            más segura de ti mismo. ¡Únete a nuestra familia y experimenta la diferencia en HealthDerma!
          </Text>

          <Flex className="mt-10" alignItems="center" justifyContent="flex-end">
            <Box fontWeight="bold" mr={5} textAlign="right">
              <Heading fontSize="30px">Ana Maria Gonzalez.</Heading>
              <Text className="text-lg" color={PRINCIPAL_COLOR}>Gerente General.</Text>
            </Box>

            <Avatar size='xl' name='Luz Dary Perez A.' src='/images/Home/gerente.webp'/>
          </Flex>
        </GridItem>

        <GridItem w="100%" px={{ base: 10, md: 0 }}>
          <Box h={{ base: '350px', md: '600px' }} overflow="hidden">
            <Image src={ImageAbout} w="100%" h="100%" objectFit="cover" borderRadius={10}
                   boxShadow="1px 1px 3px rgba(0,0,0,.2)"/>
          </Box>
        </GridItem>
      </Grid>
    </Box>)
}

export default About
