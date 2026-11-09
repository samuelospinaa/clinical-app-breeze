import { Reducer } from 'react'
import { ACTION_TYPES, Action } from './actions'

export type StateInterface = {
   isMobile: boolean;
};

export const InitialState: StateInterface = {
  isMobile: false
}

export const generalReducer: Reducer<StateInterface, Action> = (state: StateInterface, action: Action) => {
  const { type, payload } = action

  switch (type) {
    case ACTION_TYPES.SET_IS_MOBILE:
      return {
        ...state,
        isMobile: payload
      }

    default:
      return InitialState
  }
}
