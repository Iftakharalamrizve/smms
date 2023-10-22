import { createSlice } from '@reduxjs/toolkit';
import { currentUserMessageSessionList, sessionMessageHisoty} from '../actions/fbMessageAction';

const initialState = {
    assignSessionList: {},
    activeSessionList:{},
    detailsMessageList:{},
};

const FbMessage = createSlice({
  name: 'fbmessage',
  initialState,
  reducers: {
    setMessageSession(state, action) {
      let unReadIncrementNumber = 1;
      const {
        message_text,
        page_id,
        customer_id,
        session_id,
        direction,
        start_time,
        read_status,
        un_read_count,
      } = action.payload;
      let detailsModificationList = {};
      if (state.assignSessionList?.[page_id]?.[session_id]) {
        if(state.detailsMessageList.hasOwnProperty(page_id)){
          if(state.activeSessionList[page_id] == session_id){
            unReadIncrementNumber = 0;
            detailsModificationList = {
              ...state.detailsMessageList,
              [page_id]: [...state.detailsMessageList[page_id], action.payload],
            }
          }else{
            detailsModificationList = {...state.detailsMessageList}
          }
        }else{
          detailsModificationList = {...state.detailsMessageList}
        }
        return {
          ...state,
          assignSessionList: {
            ...state.assignSessionList,
            [page_id]: {
              ...state.assignSessionList[page_id],
              [session_id]: {
                ...state.assignSessionList[page_id][session_id],
                message_text,
                start_time,
                un_read_count: parseInt(state.assignSessionList[page_id][session_id]
                  .un_read_count || 0) + unReadIncrementNumber,
              },
            },
          },
          detailsMessageList: detailsModificationList
        };
      } else {
        return {
          ...state,
          assignSessionList: {
            ...state.assignSessionList,
            [page_id]: {
              ...state.assignSessionList[page_id],
              [session_id]: {
                message_text,
                page_id,
                customer_id,
                session_id,
                direction,
                start_time,
                read_status,
                un_read_count,
              },
            },
          },
        };
      }
    },
  },
  extraReducers: (builder) => {
    builder.addCase(currentUserMessageSessionList.fulfilled, (state, action) => {
      const data = action.payload;
      const formattedMessageSessionList = {};

      for (const key in data) {
        if (!formattedMessageSessionList[key]) {
          formattedMessageSessionList[key] = {};
        }
        for (const item of data[key]) {
          formattedMessageSessionList[key][item.session_id] = item;
        }
      }
      
      state.assignSessionList = formattedMessageSessionList;
    });

    builder.addCase(sessionMessageHisoty.fulfilled, (state, action) => {
      const { page_id, session_id, list } = action.payload;

      return {
        ...state,
        detailsMessageList: {
          ...state.detailsMessageList,
          [page_id]: list,
        },
        activeSessionList: {
          ...state.activeSessionList,
          [page_id]: session_id,
        },
        assignSessionList: {
          ...state.assignSessionList,
          [page_id]: {
            ...state.assignSessionList[page_id],
            [session_id]: {
              ...state.assignSessionList[page_id][session_id],
              un_read_count: 0,
            },
          },
        },
      };
    });
  },
});

export const { setMessageSession } = FbMessage.actions;
export default FbMessage.reducer;