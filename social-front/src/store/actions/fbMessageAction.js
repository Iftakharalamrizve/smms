import { createAsyncThunk } from '@reduxjs/toolkit';
import * as url from '@src/api/urls';
import { getData} from '../../api/apiCore';


export const currentUserMessageSessionList = createAsyncThunk(
    'agent/message',
    async () => {
        const response =  await getData(url.GET_SESSION_SMS_LIST);
        return response.data.data;
    },
);
  