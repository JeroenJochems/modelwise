export type ApplicationStatusEnum = 'pending' | 'accepted' | 'rejected' | 'cancelled';
export type BrandData = {
name: string;
logo: string | null;
description: string | null;
};
export type ClientData = {
name: string;
};
export type CountriesViewModel = {
countries: Array<any>;
};
export type DashboardViewModel = {
listings: Array<ListingData>;
recentlyViewedRoles: Array<RoleData>;
model: ModelData | null;
};
export type Ethnicity = 'White' | 'Black' | 'Latino' | 'Asian' | 'NativeAmerican';
export type ExtraFieldsData = {
casting_photos: boolean;
casting_videos: boolean;
};
export type EyeColor = 'Light blue' | 'Blue' | 'Light gray' | 'Gray' | 'Blue gray' | 'Gray green' | 'Green' | 'Hazel' | 'Light brown' | 'Medium brown' | 'Dark brown';
export type FieldsData = {
digitals: boolean;
height: boolean;
chest: boolean;
waist: boolean;
hips: boolean;
shoe_size: boolean;
clothing_size_top: boolean;
head: boolean;
};
export type Gender = 'Male' | 'Female' | 'Non-binary';
export type HairColor = 'Black' | 'Brown' | 'Blond' | 'Dark Blond' | 'White' | 'Gray' | 'Red' | 'Colored' | 'None' | 'Other';
export type InviteData = {
id: number;
role: RoleData;
};
export type InviteData = {
id: number;
model_id: number;
};
export type JobData = {
title: string;
description: string;
location: string | null;
brand: BrandData | null;
client: ClientData | null;
look_and_feel_photos: null | Array<PhotoData>;
};
export type ListingData = {
status: string;
id: string;
model_id: string;
model: ModelData;
role: RoleData;
invited_at: string | null;
applied_at: string | null;
extended_application_at: string | null;
shortlisted_at: string | null;
hired_at: string | null;
favorited_at: string | null;
rejected_at: string | null;
cover_letter: string | null;
brand_conflicted: string | null;
casting_questions: string | null;
available_dates: Array<any> | null;
photos: Array<PhotoData>;
casting_photos: Array<PhotoData>;
casting_videos: Array<VideoData>;
};
export type ModelCharacteristicsData = {
gender: string | null;
hair_color: HairColor | null;
hair_color_other: string | null;
eye_color: EyeColor | null;
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
export type ModelClass = 'AAA - €2000/day+' | 'A - €1000-€2000/day' | 'B - ~€600/day' | 'C - ~€400/day' | 'D - ~€200/day';
export type ModelData = {
id: string | null;
profile_picture: string | null;
first_name: string | null;
last_name: string | null;
phone_number: string | null;
city: string | null;
country: string | null;
gender: string | null;
date_of_birth: string | null;
portfolio: null | Array<ModelPhotoData>;
digitals: null | Array<ModelPhotoData>;
tattoo_photos: null | Array<ModelPhotoData>;
listings: null | Array<ListingData>;
hair_color: HairColor | null;
eye_color: EyeColor | string | null;
eye_color_other: string | null;
height: number | null;
chest: number | null;
waist: number | null;
hips: number | null;
shoe_size: number | null;
clothing_size_top: string | null;
cup_size: string | null;
instagram: string | null;
tiktok: string | null;
website: string | null;
showreel_link: string | null;
};
export type ModelDigitalData = {
path: string | null;
};
export type ModelDigitalsCollection = {
digitals: any;
};
export type ModelExclusiveCountriesViewModel = {
countryCodes: Array<any>;
};
export type ModelMeViewModel = {
me: ModelData;
};
export type ModelPersonalDetailsData = {
first_name: string | null;
last_name: string | null;
parent_first_name: string | null;
parent_last_name: string | null;
phone_number: string | null;
whatsapp_number: string | null;
city: string | null;
country: string | null;
gender: string | null;
date_of_birth: string | null;
};
export type ModelPhotoData = {
pathSquareFace?: string;
mime: string;
id: string | number;
path: string;
hash: string | null;
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
export type ModelRoleViewModel = {
role: RoleData;
listing: ListingData | null;
shootDates: Array<string>;
hasApplied: boolean;
isHired: boolean;
};
export type ModelSocialsData = {
instagram: string | null;
tiktok: string | null;
website: string | null;
showreel_link: string | null;
};
export type ModelVideoData = {
id: string;
muxId: string;
folder: string;
};
export type PhotoData = {
id: number;
path: string;
hash: string | null;
};
export type PresentationData = {
id: string;
role: RoleData;
should_show_casting_media: boolean;
should_show_digitals: boolean;
should_show_socials: boolean;
should_show_cover_letter: boolean;
should_show_conflicts: boolean;
};
export type ProfessionalExperienceViewModel = {
allCategories: Array<Tag>;
allProfessions: Array<Tag>;
selectedCategories: Array<string>;
selectedProfessions: Array<string>;
otherCategories: string | null;
};
export type RegisterModelData = {
viewedRoles: Array<any>;
email: string;
password: string | null;
};
export type RoleData = {
id: number;
name: string;
description: string | null;
start_date: string;
end_date: string | null;
fee: number;
buyout: number;
buyout_note: string | null;
travel_reimbursement_note: string | null;
photos: Array<any> | null;
public_photos: Array<any> | null;
job: JobData;
casting_video_instructions: string | null;
casting_photo_instructions: string | null;
casting_questions: string | null;
fields: FieldsData;
extra_fields: ExtraFieldsData;
};
export type Tag = {
id: number;
name: string;
slug: string;
};
export type VideoData = {
id: number;
path: string;
mux_id: string | null;
};
