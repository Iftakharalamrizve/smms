import { useEffect} from 'react';
import { useIsLoggedIn} from '@src/hooks';
import { useNavigate, Outlet } from 'react-router-dom';
import { useWebSocket } from '../context/WebSocketContext';

export default function  () {
    const currentUserLoggedInStatus = useIsLoggedIn();
    const { setAuthenticated } = useWebSocket();
    const navigate = useNavigate();
    
    useEffect(() => {
        if (currentUserLoggedInStatus == false) {
            navigate('/login');
        }else{
            setAuthenticated(true);
        }
    }, []);

    return <><Outlet /></>
}