export type Role = {
    id: number;
    job: Job;
    name: string;
    description: string;
    start_date: Date;
    end_date: Date;
    fee: number;
    fee_note: string;
    buyout: number;
    buyout_note: string;
    travel_reimbursement_note: string;
}

export type Job = {
    id: number;
    title: string;
    description: string;
    brand: Brand;
}

export type Brand = {
    id: number;
    name: string;
}

