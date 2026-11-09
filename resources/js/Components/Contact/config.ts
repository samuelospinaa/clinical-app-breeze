import * as yup from 'yup'
import { InputFormProps } from "@/Components/Common/FormFields/Interfaces";

export const validationSchema = yup.object({
  name: yup.string().required('El nombre es requerido'),
  email: yup.string().email().required('El email es requerido'),
  subject: yup.string().required('El motivo es requerido'),
  content: yup.string().required('El mensaje es requerido')
})

export const ContactInputs: InputFormProps[] = [
  {
    name: 'name',
    label: 'Nombre completo',
    placeholder: 'Escriba su nombre...',
    required: true,
    customClass: { formControl: { mb: 3 } }
  },
  {
    name: 'email',
    type: 'email',
    label: 'Correo electrónico',
    placeholder: 'Escriba su correo...',
    required: true,
    customClass: { formControl: { mb: 3 } }
  },
  {
    name: 'subject',
    label: 'Motivo',
    placeholder: 'Escriba el motivo...',
    required: true,
    customClass: { formControl: { mb: 3 } }
  },
  {
    name: 'content',
    type: 'textarea',
    label: 'Escríbenos un mensaje',
    placeholder: 'Escriba su mensaje...',
    required: true,
    customClass: { formControl: { mb: 3 } }
  }
]
