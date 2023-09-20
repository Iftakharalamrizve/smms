import { combineReducers } from 'redux';
import AuthReducers from './auth';
import Settings from './settings';
import storage from 'redux-persist/lib/storage';
import sessionStorage from 'redux-persist/lib/storage/session';
import { persistReducer } from 'redux-persist';

export const persistDataAuthConfig = {
  key: 'auth',
  storage: sessionStorage,
  transform: ['encrypt'],
};
export const reducers = combineReducers({
  Settings: Settings,
  AuthReducers: persistReducer(persistDataAuthConfig, AuthReducers),
});
