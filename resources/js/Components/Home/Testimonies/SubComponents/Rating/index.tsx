import { useMemo, JSX } from 'react'

import StarFilledIcon from '@/Components/Home/Testimonies/SubComponents/Rating/StarFilledIcon'
import StarIcon from '@/Components/Home/Testimonies/SubComponents/Rating/StarIcon'

const Rating = ({ rating }:{ rating: number }) => {
  const refillStars = (numberStars: number) => {
    const arrayRefilled: boolean[] = Array(numberStars).fill(true)

    while (arrayRefilled.length < 5) {
      arrayRefilled.push(false)
    }

    return arrayRefilled
  }

  const stars: boolean[] = useMemo(() => {
    return refillStars(rating)
  }, [rating])

  return (
    <div className="flex items-center justify-center gap-3 text-yellow-400">
      {stars.map((star: boolean, idx: number): JSX.Element => {
        if (star) return <StarFilledIcon key={idx} />
        return <StarIcon key={idx} />
      })}
    </div>
  )
}

export default Rating
