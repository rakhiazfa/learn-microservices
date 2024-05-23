import { useAuth } from "@/services/auth/auth.hook";
import { Navigate, Outlet } from "react-router-dom";

const Guest = () => {
    const { user } = useAuth();

    return user ? <Navigate to="/" replace /> : <Outlet />;
};

export default Guest;
