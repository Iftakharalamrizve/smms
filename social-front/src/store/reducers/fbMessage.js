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
      console.log("From Set Message",action);
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
    reRouteSession: (state, action) => {
      // const reRouteSessionList = action.payload;
      
      // Create a deep copy of state.assignSessionList using spread operator
    //   const stateData = { ...state.assignSessionList };
      
    //   console.log("Re Route", reRouteSessionList);
    //   console.log("Before Re Route", stateData);
    
    //   reRouteSessionList.forEach((sessionId) => {
    //     delete state.assignSessionList['104980981082367'][sessionId];
    //     for (const pageId in stateData) {
    //       if (stateData[pageId][sessionId]) {
    //         console.log(stateData[pageId][sessionId], stateData);
    //         console.log("Page Id", pageId);
    //         console.log("Find Session ", sessionId);
    
    //         // Create a deep copy of the inner object using spread operator
    //         const updatedPage = { ...stateData[pageId] };
            
    //         // Delete the specified session from the copied object
    //         delete updatedPage[sessionId];
    
    //         // Update the state with the new object
    //         stateData[pageId] = updatedPage;
    //         console.log(updatedPage);
    //       }
    //     }
    //   });
    
    //   // console.log("After Re Route", stateData);
    
    //   // Update the state with the new deep-copied object
    //  return {
    //   ...state,
    //   assignSessionList:{}
    //  }
    const reRouteSessionList = action.payload;
      console.log("Re Route Session List",reRouteSessionList);
      const currentAssignSessionList = { ...state };
      console.log("currentAssignSessionList",currentAssignSessionList.assignSessionList);
      reRouteSessionList.map((sessionId,index)=>{
        for (const pageId in currentAssignSessionList.assignSessionList) {
          if (currentAssignSessionList.assignSessionList[pageId][sessionId]) {
            console.log("Find Session",pageId,sessionId);
            const { [sessionId]: removedItem, ...rest } = currentAssignSessionList.assignSessionList[pageId];
            currentAssignSessionList.assignSessionList[pageId] = rest;
          }
        }
      });
    }
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