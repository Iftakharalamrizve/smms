import { useSelector, useDispatch } from 'react-redux';

function useIsLoggedIn() {
  return useSelector((state) => state.AuthReducers.isLoggedIn);
}

function useUserType() {
  return useSelector((state) => state.AuthReducers.user_type);
}

function useGetUserInfo(type) {
  return useSelector((state) => state.AuthReducers.user_info[type]);
}

function useGetAccessToken() {
  return useSelector((state) => state.AuthReducers.token);
}

function useGetLoaderStatus() {
  return useSelector((state) => state.Settings.isLodder);
}

export { useIsLoggedIn, useUserType, useGetLoaderStatus, useGetAccessToken, useGetUserInfo };
