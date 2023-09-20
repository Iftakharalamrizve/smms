import { createAsyncThunk } from '@reduxjs/toolkit';
import * as url from '@src/api/urls';
import { getData, createData, setAuthorization} from '../../api/apiCore';


export const userAuthenticationVerify = createAsyncThunk(
    'auth/login',
    async (credential, thunkAPI) => {
        const response =  await createData(url.LOGIN,credential);
        return response.data;
    },
);

export const logoutUser = createAsyncThunk('auth/logout', async (_, { getState }) => {
    const state = getState();
    setAuthorization(state.AuthReducers.token);
    try {
        const res = await api.create(`/logout`);
        return [];
    } catch (error) {
        return [];
    }
});
  
  