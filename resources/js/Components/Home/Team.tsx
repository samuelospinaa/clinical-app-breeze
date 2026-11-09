import { Box, Heading, Image, Text } from '@chakra-ui/react'
import Titles from '../Common/UI/Titles'
import { Navigation, Pagination } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/react'
import Container from '../Common/UI/Container'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'
import { useContext } from 'react'
import { GeneralContext } from '@/Context/GeneralContext'
import { usePage } from '@inertiajs/react'

const Team = () => {
  const { isMobile }: any = useContext(GeneralContext)
  const { members = [] }: any = usePage().props

  return (
    <Box as="section" mt={10}>
      <Container>
        <Box maxW="xl" mx="auto">
          <Titles title="Nuestro equipo profesional"/>
        </Box>

        <Box>
          <Swiper
            loop
            navigation
            spaceBetween={40}
            pagination={{ clickable: true }}
            modules={[Navigation, Pagination]}
            slidesPerView={isMobile ? 1 : 3}
          >
            {members.map((member: any, idx: number) => (
              <SwiperSlide key={idx}>
                <Box className="p-8 bg-white rounded-xl shadow-lg shadow-blue-500/10 mt-5 mb-10 mx-2">
                  <Image
                    src={member.image}
                    w="100%"
                    h="100%"
                    objectFit="cover"
                    className="transition duration-300 ease-in-out hover:scale-[101%]"
                  />

                  <Box textAlign="center" mt={10}>
                    <Heading>{member.name}</Heading>

                    <Text color={PRINCIPAL_COLOR} fontWeight="bold" className="text-md md:text-xl capitalize">
                      {member.professional_type}
                    </Text>
                  </Box>
                </Box>
              </SwiperSlide>
            ))}
          </Swiper>
        </Box>
      </Container>
    </Box>
  )
}

export default Team
