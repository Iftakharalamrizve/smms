import { createSlice } from '@reduxjs/toolkit';
import { currentUserMessageSessionList} from '../actions/fbMessageAction';

const initialState = {
    assignSessionList: []
};

const FbMessage = createSlice({
    name: 'fbmessage',
    initialState,
    reducers: {
        setMessageSession(state, action) {
            
        },
    },
    extraReducers: {
        [currentUserMessageSessionList.fulfilled]: (state, action) => {
            console.log(action.payload)
            state.assignSessionList= action.payload;
        }
      }
});
  
export const { setMessageSession } = FbMessage.actions;
export default FbMessage.reducer;
  