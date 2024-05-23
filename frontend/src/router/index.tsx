import App from "@/components/layouts/app";
import Auth from "@/components/middlewares/auth";
import Guest from "@/components/middlewares/guest";
import SignIn from "@/pages/auth/sign-in";
import Home from "@/pages/home";
import { createBrowserRouter } from "react-router-dom";

const router = createBrowserRouter([
    {
        element: <App />,
        children: [
            {
                index: true,
                element: <Home />,
            },
            {
                element: <Auth />,
                children: [],
            },
            {
                element: <Guest />,
                children: [
                    {
                        path: "/auth/signin",
                        element: <SignIn />,
                    },
                ],
            },
        ],
    },
]);

export default router;
