import { createSlice } from '@reduxjs/toolkit';
import { currentUserMessageSessionList} from '../actions/fbMessageAction';

const initialState = {
    assignSessionList: {}
};

const FbMessage = createSlice({
    name: 'fbmessage',
    initialState,
    reducers: {
        setMessageSession(state, action) {
            const { message_text, page_id, customer_id, session_id, direction, assign_time, read_status, un_read_count } = action.payload;

            if (state.assignSessionList[page_id]) {
                return {
                    ...state,
                    assignSessionList: {
                    ...state.assignSessionList,
                    [page_id]: state.assignSessionList[page_id].map((item) =>
                        item.customer_id === customer_id
                        ? { ...item, message_text, un_read_count: parseInt(item.un_read_count) + 1 }
                        : item
                    ),
                    },
                };
            } else {
                return {
                    ...state,
                    assignSessionList: {
                    ...state.assignSessionList,
                    [page_id]: [{ message_text, page_id, customer_id, session_id, direction, assign_time, read_status, un_read_count }],
                    },
                };
            }
        },
    },
    extraReducers: {
        [currentUserMessageSessionList.fulfilled]: (state, action) => {
            state.assignSessionList= action.payload;
        }
      }
});
  
export const { setMessageSession } = FbMessage.actions;
export default FbMessage.reducer;
  