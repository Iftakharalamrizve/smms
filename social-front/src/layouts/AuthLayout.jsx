import { useEffect, useState } from 'react';
import { useIsLoggedIn, useUserType, useGetLoaderStatus } from '@src/hooks';
import Loader from '@components/elements/Loader';
import { useDispatch } from 'react-redux';
import { useNavigate, Outlet } from 'react-router-dom';

export default function  () {
    const currentUserLoggedInStatus = useIsLoggedIn();
    const navigate = useNavigate();
    
    // useEffect(() => {
    //     if (currentUserLoggedInStatus == false) {
    //         navigate('/login');
    //     }
    // }, []);

    return <><Outlet /></>
}