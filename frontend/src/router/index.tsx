import App from "@/components/layouts/app";
import SignIn from "@/pages/auth/sign-in";
import Home from "@/pages/home";
import { createBrowserRouter } from "react-router-dom";

const router = createBrowserRouter([
    {
        path: "/",
        element: <App />,
        children: [
            {
                index: true,
                element: <Home />,
            },
            {
                path: "/auth/signin",
                element: <SignIn />,
            },
        ],
    },
]);

export default router;
