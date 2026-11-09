import Container from '@/Components/Common/UI/Container'
import About from '@/Components/Home/About'
import Banners from '@/Components/Home/Banners'
import GuestLayout from '@/Layouts/GuestLayout'
import { JSX } from 'react'
import Testimonies from '@/Components/Home/Testimonies'
import Team from '@/Components/Home/Team'

const Dashboard = () => {
  return (
    <>
      <Banners/>

      <Container>
        <About/>
      </Container>

      <Testimonies/>

      <Team/>
    </>
  )
}

Dashboard.layout = (page: any): JSX.Element => <GuestLayout children={page} title="Inicio"/>

export default Dashboard
