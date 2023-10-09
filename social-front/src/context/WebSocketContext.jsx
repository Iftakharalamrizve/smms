import React, { createContext, useContext, useEffect, useState } from 'react';
import { useGetAccessToken} from '@src/hooks';
const WebSocketContext = createContext();
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
export function WebSocketProvider({ children }) {
    const [authenticated, setAuthenticated] = useState(false);
    const [socketInstance, setSocketInstance] = useState(null);
    const currentUserAccessToken = useGetAccessToken();
    let socket = null;
      useEffect(() => {
        if(!socket && authenticated){
          socket = new Echo({
            broadcaster: 'pusher',
            key: 'chatroom',
            cluster: 'chatroom',
            wsHost: '127.0.0.1',
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
            authEndpoint: 'http://localhost:8000/api/broadcasting/auth',
            auth: {
              headers: {
                Authorization: `Bearer ${currentUserAccessToken}`,
              },
            },
          });
        }
        const connectWebSocket = async () => {
          if (authenticated && !socket) {
            socket.connector.connect();
          } 
          if(!authenticated && socket){
            socket.connector.disconnect();
          }
        };
        connectWebSocket();
        setSocketInstance(socket);
        return () => {
          if(socket){
            socket.connector.disconnect(); 
          }
        };
        
      }, [authenticated, socket]);
      const value = {
        socketInstance,
        authenticated,
        setAuthenticated,
      };
    return (
        <WebSocketContext.Provider value={value}>
            {children}
        </WebSocketContext.Provider>
    );
}

export function useWebSocket() {
    return useContext(WebSocketContext);
}
