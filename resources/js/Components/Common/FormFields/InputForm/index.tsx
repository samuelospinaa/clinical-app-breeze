import { useState } from 'react'
import { FaEye, FaEyeSlash } from 'react-icons/fa'
import { InputFormProps } from '../Interfaces'
import { InputWithButton } from '../styles'

import {
  Input,
  FormLabel,
  FormErrorMessage,
  FormControl,
  IconButton
} from '@chakra-ui/react'

const InputForm = ({
  name,
  label,
  register,
  errors,
  required,
  disabled,
  placeholder,
  type = 'text',
  customClass = ''
}: InputFormProps) => {
  const [showText, setShowText] = useState(false)

  const ButtonHandleShowText = () => {
    return (
         <IconButton
            ml={2}
            aria-label='Search database'
            icon={showText ? <FaEyeSlash color='gray.300' /> : <FaEye color='gray.300' />}
            onClick={() => setShowText(!showText)}
         />
    )
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
                  type={showText ? 'text' : type}
                  placeholder={placeholder}
                  {...register(name)}
               />
               {type === 'password' && (
                  <ButtonHandleShowText/>
               )}
            </InputWithButton>

            <FormErrorMessage>
               {errors[name] && errors[name].message}
            </FormErrorMessage>
         </FormControl>
      </>
  )
}

export default InputForm
