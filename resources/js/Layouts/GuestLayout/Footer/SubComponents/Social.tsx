import {Box, Flex} from "@chakra-ui/react";
import {FaFacebookF, FaInstagram, FaWhatsapp} from "react-icons/fa";

const Social = () => {
  return (
    <Flex alignItems="center" mt={5} gap={5}>
      <Box bg={'#3d4343'} p={4} color="#fff">
        <FaFacebookF size={20}/>
      </Box>
      <Box bg={'#3d4343'} p={4} color="#fff">
        <FaInstagram size={20}/>
      </Box>
      <Box bg={'#3d4343'} p={4} color="#fff">
        <FaWhatsapp size={20}/>
      </Box>
    </Flex>
  )
}

export default Social
