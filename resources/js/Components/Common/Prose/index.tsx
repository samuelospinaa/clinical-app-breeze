const Prose = ({content, className = ''}: any) => {
  return (
    <div
      className={className}
      dangerouslySetInnerHTML={{ __html: content }}/>
  )
}

export default Prose
