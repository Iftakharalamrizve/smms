import { createAsyncThunk } from '@reduxjs/toolkit';
import * as url from '@src/api/urls';
import { setMessageSession } from "@store/reducers/fbMessage";

import { getData,createData} from '../../api/apiCore';

export const currentUserMessageSessionList = createAsyncThunk(
    'agent/message',
    async () => {
        const response =  await getData(url.GET_SESSION_SMS_LIST);
        return response.data.data;
    },
);

//@TODO Error Handle 
export const sessionMessageHisoty = createAsyncThunk(
    'session/message',
    async (filterData) => {
        const response =  await getData(url.GET_SESSION_MESSAGE_DETAILS+`?session_id=${filterData.session_id}&&page_id=${filterData.page_id}&&customer_id=${filterData.customer_id}`);
        return response.data.data;
    },
);

export const messageReply = createAsyncThunk(
    'reply/message',
    async (messageData, { dispatch }) => {
        try {
            const response = await createData(url.SEND_MESSAGE_REPLY, messageData);
            const responseData = response.data.data;
            dispatch(setMessageSession(responseData));
            return responseData;
          } catch (error) {
            console.error('Error in messageReply:', error);
            throw error;
          }
    },
);
