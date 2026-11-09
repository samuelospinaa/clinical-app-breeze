import { InputFormProps } from '../Interfaces'
import { InputWithButton } from '../styles'

import {
  Input,
  FormLabel,
  FormErrorMessage,
  FormControl
} from '@chakra-ui/react'

const InputFileForm = ({
  name,
  label,
  errors,
  required,
  disabled,
  placeholder,
  customClass = '',
  setValue
}: InputFormProps) => {
  const onHandleChange = (files: any) => {
    const file = files[0]
    setValue(name, file)
  }

  return (
      <>
         <FormControl
            isInvalid={errors[name]}
            isRequired={required}
            isDisabled={disabled}
            {...customClass.formControl}
         >
            {label && <FormLabel htmlFor='name'>{label}</FormLabel>}

            <InputWithButton>
               <Input
                  type="file"
                  onChange={({ target }: any) => onHandleChange(target.files)}
                  placeholder={placeholder}
               />
            </InputWithButton>

            <FormErrorMessage>
               {errors[name] && errors[name].message}
            </FormErrorMessage>
         </FormControl>
      </>
  )
}

export default InputFileForm
