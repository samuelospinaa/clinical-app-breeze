import { useRef } from 'react'
import NavMenu from './NavMenu'
import { BurgerBars } from '../styles'

import {
  Button,
  Drawer,
  DrawerBody,
  DrawerOverlay,
  DrawerContent,
  DrawerCloseButton,
  useDisclosure
} from '@chakra-ui/react'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'

const MobileMenu = () => {
  const { isOpen, onOpen, onClose } = useDisclosure()
  const btnRef: any = useRef<any>()

  return (
      <>
         <button ref={btnRef} onClick={onOpen} className="bg-transparent inline-block w-10 mr-5 cursor-pointer">
            <BurgerBars color={PRINCIPAL_COLOR} size={20}/>
         </button>

         <Drawer
            isOpen={isOpen}
            placement='right'
            onClose={onClose}
            finalFocusRef={btnRef}
         >
            <DrawerOverlay />
            <DrawerContent>
               <DrawerCloseButton />

               <DrawerBody mt={10}>
                  <NavMenu isMobile/>
               </DrawerBody>
            </DrawerContent>
         </Drawer>
      </>
  )
}

export default MobileMenu
