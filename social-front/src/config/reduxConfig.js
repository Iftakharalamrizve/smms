import { reducers } from '@src/store/reducers';
import { configureStore } from '@reduxjs/toolkit';
import thunkMiddleware from 'redux-thunk';
import { persistStore } from 'redux-persist';

export const store = configureStore({
  reducer: reducers,
  middleware: (getDefaultMiddleware) => getDefaultMiddleware({ serializableCheck: false }).concat(thunkMiddleware),
  devTools: true,
});

export const persistor = persistStore(store);
  