import { useAuth } from "@/services/auth/auth.hook";
import { useEffect, useState } from "react";
import { Outlet } from "react-router-dom";
import Footer from "../container/footer";

const App = () => {
    const { fetchUser } = useAuth();

    const [loading, setLoading] = useState<boolean>(true);

    const getAuthenticatedUser = async () => {
        try {
            await fetchUser();
        } catch (error: any) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        getAuthenticatedUser();
    }, []);

    return !loading ? (
        <>
            <Outlet />
            <Footer />
        </>
    ) : (
        <></>
    );
};

export default App;
