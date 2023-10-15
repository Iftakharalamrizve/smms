import { createSlice } from '@reduxjs/toolkit';
import { currentUserMessageSessionList, sessionMessageHisoty} from '../actions/fbMessageAction';

const initialState = {
    assignSessionList: {},
    activeSessionList:{},
    detailsMessageList:{},
};

// state.assignSessionList[page_id].map((item) =>
//                             item.customer_id === customer_id
//                             ? { ...item, message_text,assign_time,un_read_count: parseInt(item.un_read_count) + 1 }
//                             : item
//                         )
// const FbMessage = createSlice({
//     name: 'fbmessage',
//     initialState,
//     reducers: {
//         setMessageSession(state, action) {
//             const { message_text, page_id, customer_id, session_id, direction, assign_time, read_status, un_read_count } = action.payload;

//             if (state.assignSessionList?.[page_id]?.[session_id]) {
//                 return {
//                     ...state,
//                     assignSessionList: {
//                         ...state.assignSessionList,
//                         [page_id]: {...state.assignSessionList[page_id],[session_id]:{...state.assignSessionList[page_id][session_id],message_text,assign_time,un_read_count: (state.assignSessionList[page_id][session_id].un_read_count || 0) + 1}},
//                     },
//                 };
//             } else {
//                 return {
//                     ...state,
//                     assignSessionList: {
//                         ...state.assignSessionList,
//                         [page_id]: {...state.assignSessionList[page_id],[session_id]:{ message_text, page_id, customer_id, session_id, direction, assign_time, read_status, un_read_count }},
//                     },
//                 };
//             }
//         },
//     },
//     extraReducers: (builder) => {
//         builder.addCase(currentUserMessageSessionList.fulfilled, (state, action) => {
//             let data = action.payload;
//             const formatedMessageSessionList = {};
//             for (const key in data) {
//                 if (!formatedMessageSessionList[key]) {
//                     formatedMessageSessionList[key] = {};
//                 }
            
//                 for (const item of data[key]) {
//                     formatedMessageSessionList[key][item.session_id] = item;
//                 }
//             }
//             state.assignSessionList= formatedMessageSessionList;
//         })

//         builder.addCase(sessionMessageHisoty.fulfilled, (state, action) => {
//             const {page_id, session_id, list} = action.payload;
//             return {
//                 ...state,
//                 detailsMessageList:{
//                     ...state.detailsMessageList,
//                     [page_id]:list
//                 },
//                 activeSessionList:{
//                     ...state.activeSessionList,
//                     [page_id]:session_id
//                 }
//             }
//         })
//     }
// });
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
          assign_time,
          read_status,
          un_read_count,
        } = action.payload;
  
        if (state.assignSessionList?.[page_id]?.[session_id]) {
          return {
            ...state,
            assignSessionList: {
              ...state.assignSessionList,
              [page_id]: {
                ...state.assignSessionList[page_id],
                [session_id]: {
                  ...state.assignSessionList[page_id][session_id],
                  message_text,
                  assign_time,
                  un_read_count: (state.assignSessionList[page_id][session_id]
                    .un_read_count || 0) + 1,
                },
              },
            },
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
                  assign_time,
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
  
      builder.addCase(sessionMessageHistory.fulfilled, (state, action) => {
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
        };
      });
    },
  });
  
export const { setMessageSession } = FbMessage.actions;
export default FbMessage.reducer;
  