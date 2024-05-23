import { useAuth } from "@/services/auth/auth.hook";
import { Navigate, Outlet } from "react-router-dom";

const Auth = () => {
    const { user } = useAuth();

    return user ? <Outlet /> : <Navigate to="/" replace />;
};

export default Auth;
