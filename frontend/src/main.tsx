import React from "react";
import ReactDOM from "react-dom/client";
import "./assets/css/globals.css";
import { NextUIProvider } from "@nextui-org/react";
import { RouterProvider } from "react-router-dom";
import router from "./router";
import { Provider } from "react-redux";
import { store } from "./store";

ReactDOM.createRoot(document.getElementById("root")!).render(
    <React.StrictMode>
        <NextUIProvider>
            <Provider store={store}>
                <RouterProvider router={router}></RouterProvider>
            </Provider>
        </NextUIProvider>
    </React.StrictMode>
);
