import { useAuth } from "@/services/auth/auth.hook";
import { useEffect, useState } from "react";
import { Outlet } from "react-router-dom";

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
            <footer className="px-5">
                <div className="w-full text-center p-5 border-t border-gray-300">
                    <p>
                        &copy; 2024 Great Website Studio. All rights reserved.
                    </p>
                </div>
            </footer>
        </>
    ) : (
        <></>
    );
};

export default App;
