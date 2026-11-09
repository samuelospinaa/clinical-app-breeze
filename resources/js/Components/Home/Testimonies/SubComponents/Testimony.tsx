import { Box, Heading, Text } from '@chakra-ui/react'
import Rating from '@/Components/Home/Testimonies/SubComponents/Rating'
import Prose from '@/Components/Common/Prose'

const Testimony = ({ testimony }: {testimony: any}) => {
  return (
    <Box maxW="2xl" bg="white" py={4} px={6} className="rounded-lg shadow-xl shadow-black-50/20">
      <Heading size={{ base: 'md', md: 'lg' }} textAlign="center" mb={5}>
        {testimony.title}
      </Heading>
      <Rating rating={testimony.rating}/>
      <Prose className="mt-5 text-sm md:text-md" content={testimony.body}/>
      <Text textAlign="center" mt={5} className="text-md md:text-lg font-bold">{testimony.name}</Text>
    </Box>
  )
}

export default Testimony
