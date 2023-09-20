import React from "react";
import { Box, Image, Heading } from "@components/elements";
import PulseLoader from "react-spinners/PulseLoader";
export default function Loader({ children }) {
    return (
        <>
            { true ? 
                <Box className="mc-spinner">
                    <Image src="images/logo.webp" aly="logo" />
                    <Box className="mc-spinner-group">
                        <Heading><p style={{color:"black"}}>Loading</p></Heading>
                        <PulseLoader 
                            color="#d63657"
                            loading={true} 
                            size={8} 
                        />  
                    </Box>
                </Box>
                : 
                <></>
            }
        </>
    )
}