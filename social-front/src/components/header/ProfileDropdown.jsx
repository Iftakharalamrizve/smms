import React from "react";
import { Dropdown } from "react-bootstrap";
import { useDispatch } from 'react-redux';
import { useEffect } from 'react';
import { DuelText, RoundAvatar } from "..";
import { useIsLoggedIn } from '@hooks';
import { Anchor } from "../elements";
import { logoutUser } from "../../store/actions/authAction";
import { useNavigate } from 'react-router-dom';


export default function ProfileDropdown({ name, username, image, dropdown }) {

    const dispatch = useDispatch();
    const navigate = useNavigate();
    const currentUserLoggedInStatus = useIsLoggedIn();

    // useEffect(() => {
    //     if (currentUserLoggedInStatus == false) {
    //         navigate('/login')
    //     }
    // }, [currentUserLoggedInStatus]);

    function dropdownOnclickEvent(item){
        switch(item.type){
            case 'logout':
                dispatch(logoutUser());
                break;
        }
    }

    return (
        <Dropdown className="mc-header-user">
            <Dropdown.Toggle className="mc-dropdown-toggle">
                <RoundAvatar src={ image } alt="avatar" size="xs" />
                <DuelText title={ name } descrip={ username } size="xs" />
            </Dropdown.Toggle>
            <Dropdown.Menu align="end" className="mc-dropdown-paper">
                {dropdown.map((item, index) => (
                    <Anchor
                        key={index}
                        href={item.path}
                        icon={item.icon}
                        text={item.text}
                        onClick={()=>{dropdownOnclickEvent(item)}}
                        className="mc-dropdown-menu"
                    />
                ))}
            </Dropdown.Menu>
        </Dropdown>
    )
}