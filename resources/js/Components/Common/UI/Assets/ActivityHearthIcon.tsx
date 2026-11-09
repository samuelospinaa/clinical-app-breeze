const ActivityHearthIcon = ({ size = 24, color = 'currentColor' }: any) => {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      strokeWidth="2"
      stroke={color}
      fill="none"
      strokeLinecap="round"
      strokeLinejoin="round"
    >
      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
      <path d="M3 12h4.5l1.5 -6l4 12l2 -9l1.5 3h4.5"></path>
    </svg>
  )
}

export default ActivityHearthIcon
