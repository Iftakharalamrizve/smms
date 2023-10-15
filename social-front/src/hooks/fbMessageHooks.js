import { useSelector, useDispatch } from 'react-redux';

function useCurrentAgentMessageList() {
  return useSelector((state) => state.FbMessage.assignSessionList);
}

function usecurrentActiveSessionList(type) {
  return useSelector((state) => state.FbMessage[type]);
}

export { useCurrentAgentMessageList, usecurrentActiveSessionList };