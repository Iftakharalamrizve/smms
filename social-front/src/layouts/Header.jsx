import React, { useContext, useState, useRef } from 'react';
import { LanguageDropdown, WidgetDropdown, ProfileDropdown } from '../components/header';
import { Button, Section, Box, Input } from "../components/elements";
import { DrawerContext } from '../context/Drawer';
import { ThemeContext } from '../context/Themes';
import { Logo } from '../components';
import data from "../data/master/header.json";

export default function Header() {

    const { drawer, toggleDrawer } = useContext(DrawerContext);
    const { theme, toggleTheme } = useContext(ThemeContext);
    const searchRef = useRef();
    const [scroll, setScroll] = useState("fixed");
    const [search, setSearch] = useState("");

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 0) setScroll("sticky");
        else setScroll("fixed");
    });

    document.addEventListener('mousedown', (event) => {
        if (!searchRef.current?.contains(event.target)) {
            setSearch("");
        }
    })

    return (
        <Section as="header" className={`mc-header ${ scroll }`}>
            <Logo 
                src = { data?.logo.src }
                alt = { data?.logo.alt }
                name = { data?.logo.name }
                href = { data?.logo.path } 
            />
            <Box className="mc-header-group">
                <Box className="mc-header-left">
                    <Button 
                        icon={ drawer ? "menu_open" : "menu" } 
                        className="mc-header-icon toggle" 
                        onClick={ toggleDrawer } 
                    />
                </Box>
                <Box className="mc-header-right">
                    <WidgetDropdown 
                        icon={ data.cart.icon }
                        title={ data.cart.title }
                        badge={ data.cart.badge }
                        addClass={ data.cart.addClass }
                        dropdown={ data.cart.dropdown }
                    />
                    <WidgetDropdown 
                        icon={ data.message.icon }
                        title={ data.message.title }
                        badge={ data.message.badge }
                        addClass={ data.message.addClass }
                        dropdown={ data.message.dropdown }
                    />
                    <WidgetDropdown 
                        icon={ data.notify.icon }
                        title={ data.notify.title }
                        badge={ data.notify.badge }
                        addClass={ data.notify.addClass }
                        dropdown={ data.notify.dropdown }
                    />
                    <ProfileDropdown 
                        name={ data.profile.name }
                        image={ data.profile.image }
                        username={ data.profile.username }
                        dropdown={ data.profile.dropdown }
                    />
                </Box>
            </Box>
        </Section>
    );
}

