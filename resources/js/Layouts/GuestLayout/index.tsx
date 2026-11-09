import { PropsWithChildren } from 'react'
import { Head } from '@inertiajs/react'
import Header from '@/Layouts/GuestLayout/Header'
import Footer from '@/Layouts/GuestLayout/Footer'

interface LayoutInterface extends PropsWithChildren {
  title: string
}

const GuestLayout = ({ children, title }: LayoutInterface) => {
  return (
      <>
        <Head title={title} />
        <Header/>
        <main>{children}</main>
        <Footer/>
      </>
  )
}

export default GuestLayout
