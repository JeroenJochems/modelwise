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
    is_impersonating: boolean;
    cdn_url: string;
    translations: Record<string, string>;
    ziggy: {
        location: string;
    }
};
