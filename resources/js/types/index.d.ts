export interface User {
    id: number;
    name: string;
    email: string;
    first_name: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    cdn_url: string;
    ziggy: {
        location: string;
    }
};
