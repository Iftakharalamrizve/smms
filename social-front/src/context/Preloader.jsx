import { createContext, useState, useEffect } from "react";
import { Box, Image, Heading } from "../components/elements";
import PulseLoader from "react-spinners/PulseLoader";
import { useIsLoggedIn} from '@src/hooks';
import {store} from '../config/reduxConfig';
import { setStoreReference } from "../api/apiCore";

export const LoaderContext = createContext();

export const LoaderProvider = ({ children }) => {
    const [loading, setLoading] = useState(true);
    const currentUserLoggedInStatus = useIsLoggedIn();

    useEffect(()=> {
        setLoading(true);
        setTimeout(()=> { setLoading(false) }, 1000);
    }, []);

    useEffect(() => {
        setStoreReference(store)
    }, [currentUserLoggedInStatus]);

    return (
        <LoaderContext.Provider value={{ loading }}>
            { loading ? 
                <Box className="mc-spinner">
                    <Image src="images/logo.webp" aly="logo" />
                    <Box className="mc-spinner-group">
                        <Heading><p style={{color:"black"}}>Loading</p></Heading>
                        <PulseLoader 
                            color="#d63657"
                            loading={loading} 
                            size={8} 
                        />  
                    </Box>
                </Box>
                : 
                children 
            }
        </LoaderContext.Provider>
    )
}