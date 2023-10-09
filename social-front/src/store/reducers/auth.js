import { createSlice } from '@reduxjs/toolkit';
import { userAuthenticationVerify, logoutUser } from '../actions/authAction';


const initialState = {
    isLoggedIn: false,
    token: '',
    user_info:{},
    user_type:''
};

const AuthReducer = createSlice({
    name: 'auth',
    initialState,
    extraReducers: {
      [userAuthenticationVerify.fulfilled]: (state, action) => {
        const { access_token, user, user_type } = action.payload;
        state.token = access_token;
        state.isLoggedIn = true;
        state.user_info = user;
        state.user_type = user_type;
      },
      [logoutUser.fulfilled]: () => {
        return initialState;
      },
    }
  });
  
  export const { reducer } = AuthReducer;
  export const InitalStateDate = initialState;
  export default reducer;
  