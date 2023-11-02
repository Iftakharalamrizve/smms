import { createContext, useState,useEffect } from "react";
import { Toster} from "@components";
export const ThemeContext = createContext();

export const ThemeProvider = ({ children }) => {

    const themeGet = localStorage.getItem("theme");
    const themeTag = document.querySelector("html");
    const [toasterData, setToasterMessage] = useState(null);
    const [theme, setTheme] = useState(themeGet ? themeGet : "light_mode");

    if(theme !== "light_mode") themeTag.classList.replace("light_mode", "dark_mode");
    else themeTag.classList.replace("dark_mode", "light_mode");

    const lightTheme = () => {
        setTheme("light_mode");
        localStorage.setItem("theme", "light_mode");
        themeTag.classList.replace("dark_mode", "light_mode");
    }

    const darkTheme = () => {
        setTheme("dark_mode");
        localStorage.setItem("theme", "dark_mode");
        themeTag.classList.replace("light_mode", "dark_mode");
    }

    const toggleTheme = () => {
        if(theme !== "light_mode") lightTheme();
        else darkTheme();
    }

    const showTosterMessage = (message,type) => {
        console.log(message,type);
        setToasterMessage({message,type});
    }

    useEffect(()=>{
        console.log("Hello Bangladesh")
    },[toasterData])

    return (
        <ThemeContext.Provider value={{ theme, toggleTheme, showTosterMessage }}>
            { children }
            {toasterData && <Toster data = {toasterData} />}
        </ThemeContext.Provider>
    )
}