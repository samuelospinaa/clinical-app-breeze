import { Box, Text } from '@chakra-ui/react'
import { Parallax } from '@/Components/Home/styles'
import Container from '@/Components/Common/UI/Container'
import Titles from '@/Components/Common/UI/Titles'
import { Navigation, Pagination } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/react'
import { useContext } from 'react'
import { GeneralContext } from '@/Context/GeneralContext'
import { usePage } from '@inertiajs/react'
import Testimony from '@/Components/Home/Testimonies/SubComponents/Testimony'

const Testimonies = () => {
  const { testimonies = [] }: any = usePage().props
  const { isMobile }: any = useContext(GeneralContext)

  return (
    <Box position="relative" mt={10}>
      <Box bg="#000" zIndex={-2} h="100%" pos="absolute" top={0} left={0} right={0}/>
      <Parallax className="mx-auto overflow-y-scroll bg-cover bg-fixed bg-center bg-no-repeat shadow-lg"/>

      <Box p={{ base: 5, md: 100 }}>
        <Container>
          <Titles title="Nuestros pacientes dicen..." letterColor="#fff"/>
          <Text color="#fff" maxW="3xl" mx="auto" textAlign="center" mt={5}>
            En esta sección, descubre lo que dicen nuestros clientes sobre su experiencia en nuestro spa exclusivo.
            "Consiente tu cuerpo y alma" va más allá de un lema; es la realidad que comparten aquellos que han vivido la
            transformación en nuestro santuario de serenidad. Explora los testimonios que destacan tratamientos
            personalizados, un ambiente sereno y un equipo de terapeutas excepcionales. Cada palabra refleja la
            verdadera indulgencia y tranquilidad que ofrecemos. Sumérgete en las historias de renovación y descubre por
            qué nuestros clientes eligen nuestro spa como su refugio de bienestar.
          </Text>

          <Box mt={10}>
            <Swiper
              loop
              navigation
              spaceBetween={50}
              pagination={{ clickable: true }}
              modules={[Navigation, Pagination]}
              slidesPerView={isMobile ? 1 : 3}
            >
              {testimonies.map((testimony: any, idx: number) => (<SwiperSlide key={idx}>
                  <Testimony testimony={testimony}/>
                </SwiperSlide>))}
            </Swiper>
          </Box>
        </Container>
      </Box>
    </Box>
  )
}

export default Testimonies
