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
      if (state.assignSessionList?.[page_id]?.[session_id]) {
        const activeSession = state.activeSessionList[page_id] === session_id;
        const unReadIncrementNumber = activeSession ? 0 : 1;
        const isDispostionResponse = action.payload.disposition_id? true: false;
        const updatedPage = { ...state.assignSessionList[page_id] };
        const updateActiveSessionList = {...state.activeSessionList};
        const updateDetailsMessage = { ...state.detailsMessageList};
        
        if(isDispostionResponse){
          delete updatedPage[session_id];
          delete updateActiveSessionList[page_id]; 
          delete updateDetailsMessage[page_id];
        }
        
        return {
          ...state,
          assignSessionList: isDispostionResponse?{
            ...state.assignSessionList,
            [page_id]:updatedPage
          }:{
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
          detailsMessageList: isDispostionResponse?updateDetailsMessage:activeSession?{
            ...state.detailsMessageList,
            [page_id]:activeSession
              ? [...state.detailsMessageList[page_id], action.payload]
              : [...state.detailsMessageList[page_id]],
          }:state.detailsMessageList,
          activeSessionList: isDispostionResponse?{...updateActiveSessionList}:state.activeSessionList
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
    reRouteSession(state, action) {
      const reRouteSessionList = action.payload;
      console.log(reRouteSessionList);
      // if(true) {
      //   return {
      //     ...state,
      //     assignSessionList: {
      //       ...state.assignSessionList,
      //       [page_id]: {
      //         ...state.assignSessionList[page_id],
      //         [session_id]: {
      //           message_text,
      //           page_id,
      //           customer_id,
      //           session_id,
      //           direction,
      //           start_time,
      //           read_status,
      //           un_read_count,
      //         },
      //       },
      //     },
      //   };
      // }
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

export const { setMessageSession, reRouteSession } = FbMessage.actions;
export default FbMessage.reducer;