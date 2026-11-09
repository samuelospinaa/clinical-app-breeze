import { FormControl, FormErrorMessage, FormLabel, Select } from '@chakra-ui/react'

const SelectForm = ({
  name,
  label,
  errors,
  register,
  disabled,
  required,
  placeholder,
  options = [],
  customClass = ''
}: any) => {
  return (
      <FormControl
         isInvalid={errors[name]}
         isRequired={required}
         isDisabled={disabled}
         {...customClass.formControl}
      >
         {label && <FormLabel htmlFor='name'>{label}</FormLabel>}

         <Select
            placeholder={placeholder}
            {...register(name)}
         >
            {options.map((option: any, idx: number) => (
               <option key={idx} value={option.value}>{option.label}</option>
            ))}
         </Select>

         <FormErrorMessage>
            {errors[name] && errors[name].message}
         </FormErrorMessage>
      </FormControl>
  )
}

export default SelectForm
