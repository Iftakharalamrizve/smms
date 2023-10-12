import { createSlice } from '@reduxjs/toolkit';
import { agentCurrentModeSetAndGet} from '../actions/agentAction';

const initialState = {
    currentAgentMode:null
};

const AgentOperation = createSlice({
    name: 'agentmanage',
    initialState,
    extraReducers: {
        [agentCurrentModeSetAndGet.fulfilled]: (state, action) => {
            state.currentAgentMode= action.payload.data.agentMode;
        }
      }
});
  
export default AgentOperation.reducer;
  