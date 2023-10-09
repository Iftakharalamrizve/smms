import { ThemeProvider } from "./context/Themes";
import { LoaderProvider } from "./context/Preloader";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { CRM, Login, Message, BlankPage, MyAccount } from "@pages/master";
import { Provider } from 'react-redux';
import { PersistGate } from 'redux-persist/integration/react';
import { store, persistor } from './config/reduxConfig';
import AuthLayout from '@src/layouts/AuthLayout';
import { WebSocketProvider } from './context/WebSocketContext';

export default function App() {
    return (
        <Provider store={store}>
            <PersistGate loading={null} persistor={persistor}>
                <ThemeProvider>
                    <LoaderProvider>
                        <BrowserRouter basename="/">
                            <WebSocketProvider>
                                <Routes>
                                    <Route element={<AuthLayout />}>
                                        <Route path="/" element={<CRM />} />
                                        <Route path="/message" element={<Message />} />
                                        <Route path="/blank-page" element={<BlankPage />} />
                                        <Route path="/my-account" element={<MyAccount />} />
                                    </Route>
                                    <Route path="/login" element={<Login />} />
                                </Routes>
                            </WebSocketProvider>
                        </BrowserRouter>
                    </LoaderProvider>
                </ThemeProvider>
            </PersistGate>
        </Provider>
    );
}
