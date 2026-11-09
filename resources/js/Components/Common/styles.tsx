import styled from '@emotion/styled'

const ContainerNextImages = styled.div`
  position: relative;
  height: 0;
  
  & img {
    width: 100%;
    height: 100%;
  }
`

export const ContainerImages = styled(ContainerNextImages)`
  padding-bottom: 100%;
`

export const ContainerBannerImages = styled(ContainerNextImages)`
  padding-top: calc(60% / (16 / 9));
`
