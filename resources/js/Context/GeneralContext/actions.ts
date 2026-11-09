export enum ACTION_TYPES {
   // eslint-disable-next-line no-unused-vars
   SET_IS_MOBILE = 'SET_CATEGORIES',
}

export type Action = {
   type: ACTION_TYPES;
   payload?: any;
};

export const setIsMobile = (isMobile: boolean): Action => ({
  type: ACTION_TYPES.SET_IS_MOBILE,
  payload: isMobile
})
