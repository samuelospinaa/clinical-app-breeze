import InputForm from './InputForm'
import SelectForm from './SelectForm'
import TextareaForm from './TextareaForm'
import { InputFormProps } from './Interfaces'
import InputFileForm from './InputFileForm'

export {
  SelectForm,
  InputForm,
  TextareaForm,
}

const FormFields = ({ type, ...props }: InputFormProps) => {
  if (type === 'select') return <SelectForm type={type} {...props}/>
  if (type === 'textarea') return <TextareaForm type={type} {...props}/>
  if (type === 'inputFile') return <InputFileForm type={type} {...props}/>

  return <InputForm type={type} {...props}/>
}

export default FormFields
