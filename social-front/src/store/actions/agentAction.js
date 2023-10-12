import { createAsyncThunk } from '@reduxjs/toolkit';
import * as url from '@src/api/urls';
import { getData} from '../../api/apiCore';

export const agentCurrentModeSetAndGet = createAsyncThunk(
    'agent/assign_status',
    async () => {
        const response =  await getData(url.SET_CURRENT_AGENT_MODE);
        return response.data;
    },
);
  