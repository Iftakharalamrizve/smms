import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import { userAuthenticationVerify, logoutUser } from '../actions/authAction';


const initialState = {
    isLodder: false
};

const Settings = createSlice({
    name: 'settings',
    initialState,
    reducers: {
        setLoader(state, action) {
            state.isLodder = action.payload
        },
    },
});
  
export const { setLoader } = Settings.actions;
export default Settings.reducer;
  