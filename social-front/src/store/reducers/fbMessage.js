import { createSlice } from '@reduxjs/toolkit';
import { currentUserMessageSessionList} from '../actions/fbMessageAction';

const initialState = {
    assignSessionList: []
};

const Settings = createSlice({
    name: 'fbmessage',
    initialState,
    reducers: {
        setMessageSession(state, action) {
            
        },
    },
    extraReducers: {
        [currentUserMessageSessionList.fulfilled]: (state, action) => {
          
        }
      }
});
  
export const { setMessageSession } = Settings.actions;
export default Settings.reducer;
  