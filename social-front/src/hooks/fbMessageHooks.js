import { useSelector, useDispatch } from 'react-redux';

function useCurrentAgentMessageList() {
  return useSelector((state) => state.FbMessage.assignSessionList);
}

export { useCurrentAgentMessageList };