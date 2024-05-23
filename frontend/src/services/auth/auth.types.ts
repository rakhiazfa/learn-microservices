export type SignInPayload = {
    email: string;
    password: string;
};

export type User = {
    id: number;
    avatar: string;
    name: string;
    email: string;
    is_active: boolean;
    roles: Role[];
    created_at: Date;
    updated_at: Date;
};

export type Role = {
    id: number;
    name: string;
};

export type AuthErrors = {
    unauthenticated?: string;
};
