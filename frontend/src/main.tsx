import React from "react";
import ReactDOM from "react-dom/client";
import "./assets/css/globals.css";
import { RouterProvider } from "react-router-dom";
import router from "./router";
import { Provider } from "react-redux";
import { store } from "./store";

ReactDOM.createRoot(document.getElementById("root")!).render(
    <React.StrictMode>
        <Provider store={store}>
            <RouterProvider router={router}></RouterProvider>
        </Provider>
    </React.StrictMode>
);
