import { createSelector, createSlice } from "@reduxjs/toolkit";
import { RootState } from "../../store";
import { User } from "@/services/auth/auth.types";

type AuthState = {
    user: User | null;
};

const initialState = (): AuthState => ({
    user: null,
});

const authSlice = createSlice({
    name: "auth",
    initialState: initialState(),
    reducers: {
        setUser(state, { payload }) {
            state.user = payload;
        },
    },
});

export const authReducer = authSlice.reducer;
export const { setUser } = authSlice.actions;
export const authSelector = createSelector(
    (state: RootState) => state,
    (state: RootState) => state.auth
);
