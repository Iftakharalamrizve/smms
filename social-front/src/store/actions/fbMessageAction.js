import { createAsyncThunk } from '@reduxjs/toolkit';
import * as url from '@src/api/urls';
import { getData, createData, setAuthorization} from '../../api/apiCore';


export const currentUserMessageSessionList = createAsyncThunk(
    'agent/message',
    async (credential, thunkAPI) => {
        const response =  await createData(url.LOGIN,credential);
        return response.data;
    },
);
  