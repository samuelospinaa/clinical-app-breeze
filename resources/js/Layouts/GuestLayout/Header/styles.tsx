import styled from '@emotion/styled'
import { ListItem } from '@chakra-ui/react'
import { PRINCIPAL_COLOR } from '@/Components/Common/variables'
import { FaBars } from 'react-icons/fa'

export const BurgerBars: any = styled(FaBars)`
  display: block;
  margin: auto;
`

export const HeaderMenu: any = styled.header`
  position: sticky;
  top: 0;
  z-index: 999;
  box-shadow: 2px 2px 3px rgba(0, 0, 0, .1);
  background: #fff;

  @media (max-width: 768px) {
    display: none;
  }
`

export const ItemNav: any = styled(ListItem)`
  margin: 0 20px;

  & p {
    border-bottom: 2px solid transparent;
    color: #535353;
  }

  & [aria-current]:not([aria-current="false"]) {
    font-weight: bold;

    & p {
      color: ${PRINCIPAL_COLOR};
      border-bottom: 2px solid ${PRINCIPAL_COLOR};
    }
  }

  @media (max-width: 768px) {
    margin: 10px 0;
  }
`
