import { useSelector, useDispatch } from 'react-redux';
import { setLoader } from '../store/reducers/settings'

function useIsLoggedIn() {
  const isLoggedInStatus = useSelector((state) => state.AuthReducers.isLoggedIn);
  return isLoggedInStatus;
}
function useUserType() {
  const userType = useSelector((state) => state.AuthReducers.user_type);
  return userType;
}



function useGetLoaderStatus() {
  return useSelector((state) => state.Settings.isLodder);
}

export { useIsLoggedIn, useUserType, useGetLoaderStatus };
