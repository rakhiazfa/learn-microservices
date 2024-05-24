import { useState } from "react";
import AuthService from "./auth.service";
import { AuthErrors, SignInPayload } from "./auth.types";
import Cookies from "js-cookie";
import { useDispatch, useSelector } from "react-redux";
import { authSelector, setUser } from "./auth.slice";

export const useAuth = () => {
    const { user } = useSelector(authSelector);
    const dispatch = useDispatch();

    const [loading, setLoading] = useState<boolean>(false);
    const [errors, setErrors] = useState<AuthErrors>({});

    const signIn = async (payload: SignInPayload): Promise<boolean> => {
        setLoading(true);

        try {
            const data = await AuthService.signIn(payload);

            Cookies.set("ACCESS_TOKEN", data?.authorization?.token);
            await fetchUser();

            return true;
        } catch (error: any) {
            if (error.response?.status === 401) {
                setErrors((oldValue) => ({
                    ...oldValue,
                    unauthenticated:
                        "The provided credentials do not match our records.",
                }));
            }

            return false;
        } finally {
            setLoading(false);
        }
    };

    const signOut = async (): Promise<boolean> => {
        setLoading(true);

        try {
            await AuthService.signOut();

            Cookies.remove("ACCESS_TOKEN");
            dispatch(setUser(null));

            return true;
        } catch (error: any) {
            console.log(error.response);

            return false;
        } finally {
            setLoading(false);
        }
    };

    const fetchUser = async (): Promise<void> => {
        const accessToken = Cookies.get("ACCESS_TOKEN") ?? null;

        if (accessToken) {
            const { user } = await AuthService.fetchUser();
            dispatch(setUser(user));
        }
    };

    return { signIn, signOut, fetchUser, user, loading, errors };
};
