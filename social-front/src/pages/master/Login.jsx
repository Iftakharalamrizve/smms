import React, { useState, useRef } from "react";
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { useNavigate } from 'react-router-dom';
import { useIsLoggedIn } from '../../hooks';
import { Box, Form, Heading, Button, Anchor, Image, Text, Input, Icon } from "../../components/elements";
import Logo from "../../components/Logo";
import data from "../../data/master/login.json";
import { userAuthenticationVerify } from "../../store/actions/authAction";


export default function Login() {
    const form = useRef();
    const checkBtn = useRef();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const currentUserLoggedInStatus = useIsLoggedIn();

    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [message, setMessage] = useState("");

    const handleUserNameInputChange = (username) => {
        setUsername(username);
    };

    const handlePasswordInputChange = (password) => {
        setPassword(password);
    };

    useEffect(() => {
        if (currentUserLoggedInStatus == true) {
            navigate('/')
        }
    }, [currentUserLoggedInStatus]);

    const handleLogin = (e) => {
        e.preventDefault();
        dispatch(userAuthenticationVerify({ username, password }));
    };

    return (
        <Box className="mc-auth">
            <Image
                src={ data?.pattern.src } 
                alt={ data?.pattern.alt }
                className="mc-auth-pattern"  
            />
            <Box className="mc-auth-group">
                <Logo 
                    src = { data?.logo.src }
                    alt = { data?.logo.alt }
                    href = { data?.logo.path }
                    className = "mc-auth-logo"
                />
                <Heading as="h4" className="mc-auth-title">{ data?.title }</Heading>
                <Form  onSubmit={handleLogin}  className="mc-auth-form">
                    <Box className={`mc-icon-field ${ "w-100 h-sm" || "w-md h-sm white" }`}>
                        <Icon type={ 'person' || "account_circle" } />
                        <Input 
                            type="text" 
                            value= {username}
                            placeholder="Enter user name"
                            onChange={handleUserNameInputChange}
                        />
                    </Box>
                    <Box className={`mc-icon-field ${ "w-100 h-sm" || "w-md h-sm white" }`}>
                        <Icon type={ 'lock' || "account_circle" } />
                        <Input 
                            type="password" 
                            value= {password}
                            placeholder="Enter password"
                            onChange={handlePasswordInputChange}
                        />
                    </Box>
                    <Button className={`mc-auth-btn ${data?.button.fieldSize}`} type='submit'>{ data?.button.text }</Button>
                </Form>
            </Box>
        </Box>
    );
}