import { useSelector, useDispatch } from 'react-redux';

function useIsLoggedIn() {
  return useSelector((state) => state.AuthReducers.isLoggedIn);
}

function useUserType() {
  return useSelector((state) => state.AuthReducers.user_type);
}

function useGetUserInfo(type = null) {
  if(type){
    return useSelector((state) => state.AuthReducers.user_info[type]);
  }
  return useSelector((state) => state.AuthReducers.user_info);
}

function useGetAccessToken() {
  return useSelector((state) => state.AuthReducers.token);
}

function useGetLoaderStatus() {
  return useSelector((state) => state.Settings.isLodder);
}

export { useIsLoggedIn, useUserType, useGetLoaderStatus, useGetAccessToken, useGetUserInfo };
