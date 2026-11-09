import NavMenu from './SubComponents/NavMenu'
import { HeaderMenu } from './styles'
import FirstHeader from '@/Layouts/GuestLayout/Header/SubComponents/FirstHeader'

const Header = () => {
  return (
     <>
       <FirstHeader/>

       <HeaderMenu>
         <NavMenu/>
       </HeaderMenu>
     </>
  )
}

export default Header
