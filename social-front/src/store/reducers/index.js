import { combineReducers } from 'redux';
import AuthReducers from './auth';
import Settings from './settings';
import FbMessage from './fbMessage';
import agentOperation from './agentOperation';
import storage from 'redux-persist/lib/storage';
import thunkMiddleware from 'redux-thunk';
import sessionStorage from 'redux-persist/lib/storage/session';
import { persistReducer } from 'redux-persist';

export const persistDataAuthConfig = {
  key: 'auth',
  storage: sessionStorage,
  transform: ['encrypt'],
};

export const reducers = combineReducers({
  Settings: Settings,
  FbMessage:FbMessage,
  agentOperation:agentOperation,
  AuthReducers: persistReducer(persistDataAuthConfig, AuthReducers),
});
