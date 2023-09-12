declare namespace App.ViewModels {
export type CountriesViewModel = {
countries: Array<any>;
};
export type DashboardViewModel = {
openInvites: any;
openApplications: any;
recentlyViewedRoles: any;
hires: any;
model: any | any;
};
export type ModelExclusiveCountriesViewModel = {
countryCodes: Array<any>;
};
export type ModelMeViewModel = {
me: Domain.Profiles.Data.ModelData;
};
export type ProfessionalExperienceViewModel = {
allCategories: Array<App.ViewModels.Tag>;
allProfessions: Array<App.ViewModels.Tag>;
selectedCategories: Array<string>;
selectedProfessions: Array<string>;
otherCategories: string | null;
};
export type RoleApplyViewModel = {
role: Domain.Jobs.Data.RoleData;
isInvited: boolean;
hasApplied: boolean;
shootDates: Array<any>;
viewedRoles: Array<any>;
};
export type Tag = {
id: number;
name: string;
slug: string;
};
}
declare namespace Domain.Jobs.Data {
export type ApplicationData = {
id: string;
status: Domain.Jobs.Enums.ApplicationStatusEnum;
hire: Domain.Jobs.Data.HireData | null;
rejection: Domain.Jobs.Data.RejectionData | null;
};
export type BrandData = {
name: string;
logo: string | null;
description: string | null;
};
export type ClientData = {
name: string;
};
export type FieldsData = {
digitals: boolean;
height: boolean;
chest: boolean;
waist: boolean;
hips: boolean;
shoe_size: boolean;
head: boolean;
};
export type HireData = {
id: string;
};
export type InviteData = {
id: number;
};
export type JobData = {
title: string;
location: string;
description: string;
brand: Domain.Jobs.Data.BrandData | null;
client: Domain.Jobs.Data.ClientData | null;
look_and_feel_photos: Array<Domain.Profiles.Data.PhotoData>;
};
export type RejectionData = {
id: string;
};
export type RoleData = {
fields: Domain.Jobs.Data.FieldsData;
id: number;
name: string;
description: string;
start_date: string;
end_date: string | null;
fee: number;
buyout: number;
buyout_note: string | null;
travel_reimbursement_note: string | null;
photos: Array<Domain.Profiles.Data.PhotoData>;
public_photos: Array<Domain.Profiles.Data.PhotoData>;
job: Domain.Jobs.Data.JobData;
my_invites: Array<Domain.Jobs.Data.InviteData> | null;
my_applications: Array<Domain.Jobs.Data.ApplicationData> | null;
};
}
declare namespace Domain.Jobs.Enums {
export type ApplicationStatusEnum = 'pending' | 'accepted' | 'rejected' | 'cancelled';
}
declare namespace Domain.Profiles.Data {
export type InviteData = {
id: number;
role: Domain.Jobs.Data.RoleData;
};
export type ModelCharacteristicsData = {
gender: string | null;
hair_color: Domain.Profiles.Enums.HairColor | null;
hair_color_other: string | null;
eye_color: Domain.Profiles.Enums.EyeColor | null;
eye_color_other: string | null;
height: string | null;
chest: string | null;
waist: string | null;
hips: string | null;
shoe_size: string | null;
cup_size: string | null;
tattoos: boolean | null;
piercings: boolean | null;
};
export type ModelData = {
profile_picture: string | null;
first_name: string | null;
last_name: string | null;
phone_number: string | null;
city: string | null;
country: string | null;
gender: string | null;
date_of_birth: string | null;
portfolio: Array<Domain.Profiles.Data.ModelPhotoData>;
digitals: Array<Domain.Profiles.Data.ModelPhotoData>;
tattoo_photos: Array<Domain.Profiles.Data.ModelPhotoData>;
applications: Array<Domain.Jobs.Data.ApplicationData>;
height: number;
chest: number;
waist: number;
hips: number;
shoe_size: number;
};
export type ModelDigitalData = {
path: string | null;
};
export type ModelDigitalsCollection = {
digitals: any;
};
export type ModelPersonalDetailsData = {
first_name: string | null;
last_name: string | null;
parent_first_name: string | null;
parent_last_name: string | null;
phone_number: string | null;
city: string | null;
country: string | null;
gender: string | null;
date_of_birth: string | null;
};
export type ModelPhotoData = {
id: string;
path: string;
};
export type ModelPhotosCollection = {
digitals: any;
};
export type ModelPortfolioCollection = {
portfolio: any;
};
export type ModelProfilePictureData = {
profile_picture: string | null;
};
export type ModelSocialsData = {
instagram: string | null;
tiktok: string | null;
website: string | null;
};
export type PhotoData = {
path_square_face: string;
id: number;
path: string;
};
export type RegisterModelData = {
viewedRoles: Array<any>;
email: string;
password: string | null;
};
}
declare namespace Domain.Profiles.Enums {
export type Ethnicity = 'White' | 'Black' | 'Latino' | 'Asian' | 'NativeAmerican';
export type EyeColor = 'Light blue' | 'Blue' | 'Light gray' | 'Gray' | 'Blue gray' | 'Gray green' | 'Green' | 'Hazel' | 'Light brown' | 'Medium brown' | 'Dark brown';
export type HairColor = 'Black' | 'Brown' | 'Blond' | 'White/Gray' | 'Red' | 'Colored' | 'None' | 'Other';
}
