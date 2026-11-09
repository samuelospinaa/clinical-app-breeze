import { AspectRatio, Button, Container, Grid, GridItem } from '@chakra-ui/react'
import { yupResolver } from '@hookform/resolvers/yup'
import { useForm } from 'react-hook-form'
import { ContactInputs, validationSchema} from "@/Components/Contact/config";
import FormFields from "@/Components/Common/FormFields";
import { sendSuccessMessage } from "@/Components/Toast/messages";
import {JSX} from "react";
import Layout from "@/Layouts/GuestLayout";
import { router } from "@inertiajs/react";
import Titles from "@/Components/Common/UI/Titles";
import {PRINCIPAL_COLOR} from "@/Components/Common/variables";

const Contact = () => {
  const { handleSubmit, control, reset, formState, ...formProps }: any = useForm({
    resolver: yupResolver(validationSchema)
  })

  const onHandleSubmit = async (values: any) => {
    router.post(route('messages.store'), values, {
      onSuccess: () => {
        sendSuccessMessage()
      }
    })
  }

  return (
    <Container maxW='7xl' my={10}>
      <Titles title="Contáctanos"/>

      <Grid templateColumns={{ base: '1fr', md: 'repeat(2, 1fr)' }} gap={6} mt={10}>
        <GridItem w='100%'>
          <AspectRatio maxW='560px' ratio={1}>
            <iframe
              src='https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d7932.892692631763!2d-75.57530110796486!3d6.204703033467163!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1699679689150!5m2!1ses!2sco'
              allowFullScreen
            />
          </AspectRatio>
        </GridItem>
        <GridItem w='100%'>
          <form onSubmit={handleSubmit(onHandleSubmit)} encType="multipart/form-data">
            {ContactInputs.map((input: any, idx: number) => (
              <FormFields
                key={idx}
                errors={formState.errors}
                {...input}
                {...formProps}
              />
            ))}

            <Button color="white" type="submit" display="block" w="100%" mt={20} bg={PRINCIPAL_COLOR}>
              Enviar mensaje
            </Button>
          </form>
        </GridItem>
      </Grid>
    </Container>
  )
}

Contact.layout = (page: any): JSX.Element => <Layout children={page} title="Portafolio" />

export default Contact
