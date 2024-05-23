import api from "@/endpoints/api";
import { SignInPayload } from "./auth.types";

class AuthService {
    static async signIn(payload: SignInPayload) {
        const { data } = await api.post(`/auth/signin`, payload);

        return data;
    }

    static async signOut() {
        const { data } = await api.post(`/auth/signout`);

        return data;
    }

    static async fetchUser() {
        const { data } = await api.get(`/auth/user`, {
            headers: {
                Authorization: "Bearer test",
            },
        });

        return data;
    }
}

export default AuthService;
