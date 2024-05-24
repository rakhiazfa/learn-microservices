import App from "@/components/layouts/app";
import Default from "@/components/layouts/default";
import Guest from "@/components/middlewares/guest";
import SignIn from "@/pages/auth/sign-in";
import Home from "@/pages/home";
import { createBrowserRouter } from "react-router-dom";

const router = createBrowserRouter([
    {
        element: <App />,
        children: [
            {
                element: <Default />,
                children: [
                    {
                        index: true,
                        element: <Home />,
                    },
                ],
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
