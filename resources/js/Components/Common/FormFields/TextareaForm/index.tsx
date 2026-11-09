import { FormControl, FormErrorMessage, FormLabel, Textarea } from '@chakra-ui/react'

const TextareaForm = ({ errors, name, label, placeholder, required, disabled, customClass, register }: any) => {
  return (
      <FormControl
         isInvalid={errors[name]}
         isRequired={required}
         isDisabled={disabled}
         {...customClass?.formControl}
      >
         {label && <FormLabel htmlFor='name'>{label}</FormLabel>}

         <Textarea
            rows={4}
            placeholder={placeholder}
            {...register(name)}
         />

         <FormErrorMessage>
            {errors[name] && errors[name].message}
         </FormErrorMessage>
      </FormControl>
  )
}

export default TextareaForm
