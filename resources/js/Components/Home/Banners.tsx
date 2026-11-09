import { usePage } from '@inertiajs/react'
import { Swiper, SwiperSlide } from 'swiper/react'
import { Navigation, Pagination } from 'swiper/modules'
import { Box, Button, Flex, Heading, Image } from '@chakra-ui/react'
import Prose from '@/Components/Common/Prose'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'

const Banners = () => {
  const { banners = [] }: any = usePage().props

  return (
    <Swiper
      loop
      navigation
      spaceBetween={50}
      slidesPerView={1}
      pagination={{ clickable: true }}
      modules={[Navigation, Pagination]}
    >
      {banners.map((banner: any, idx: number) => (
        <SwiperSlide key={idx}>
          <Flex alignItems="center" position="relative" maxH={600}>
            <Image src={banner.image} w="100%" h="100%" objectFit="cover"/>
            <Box position="absolute" maxW="2xl" px={{ base: '40px', md: '100px' }}>
              {banner.title && <Heading size={{ base: 'md', md: '2xl' }}>{banner.title}</Heading>}
              {banner.content && <Prose className="mt-5 text-xs md:text-lg" content={banner.content}/>}

              {banner.linkButton?.text && (
                <a href={banner.linkButton.url} target="_blank" rel="noreferrer">
                  <Button className={'bg-white hover:text-black py-2 px-4 rounded mt-5 font-bold'} color={PRINCIPAL_COLOR}>
                    {banner.linkButton.text}
                  </Button>
                </a>
              )}
            </Box>
          </Flex>
        </SwiperSlide>
      ))}
    </Swiper>
  )
}

export default Banners
