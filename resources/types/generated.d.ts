declare namespace App.Data {
export type AddressData = {
id?: number;
type: App.Enums.AddressType;
state?: string;
country?: string;
street: string;
city: string;
};
export type BoardData = {
id?: number;
name: string;
project_id?: number;
tasks?: Array<App.Data.TaskData>;
};
export type CommentData = {
id?: number;
body: string;
task_id: number;
created_at?: string;
user_id?: number;
user?: App.Data.UserData;
task?: App.Data.TaskData;
files?: Array<App.Data.FileData>;
};
export type ContactData = {
cid: string;
first_name: string;
last_name: string;
user_id?: number;
title?: App.Enums.Title;
job_title?: string;
firm?: App.Data.FirmData;
emails?: Array<App.Data.EmailData>;
};
export type ContactFullData = {
id?: number;
cid?: string;
first_name: string;
last_name: string;
nickname?: string;
middle_name?: string;
job_title?: string;
bio?: string;
user_id?: number;
phones: Array<App.Data.PhoneData>;
emails: Array<App.Data.EmailData>;
interactions?: Array<App.Data.InteractionData>;
firm?: App.Data.FirmData;
title: string;
};
export type EmailData = {
id?: number;
email: string;
is_primary_email: boolean;
};
export type FileData = {
id?: number;
fid?: string | null;
filename?: string;
mime_type?: string;
full_url?: string;
file_path?: string;
user_id?: number;
user?: App.Data.UserData;
size?: number;
};
export type FirmData = {
id?: number;
fid?: string;
slogan?: string;
address?: App.Data.AddressData;
url?: string;
name?: string;
tags?: Array<App.Data.TagData>;
};
export type InteractionData = {
id?: number;
user_id: number;
contact_id: number;
description?: string;
contact?: App.Data.ContactData;
interaction_type: string;
event_date: string;
display_event_date?: string;
location: string;
};
export type NotificationData = {
id?: string;
type?: string;
notifiable_type?: string;
notifiable_id?: number;
data: Array<App.Data.UserData>;
read_at?: string;
created_at?: string;
updated_at?: string;
};
export type PhoneData = {
id?: number;
country_code?: string;
type?: App.Enums.PhoneType;
is_primary_phone: boolean;
formatted?: string;
number: string;
};
export type ProjectData = {
pid: string;
name: string;
created_at?: string;
due_date: string;
status: string;
contact: App.Data.ContactData;
author: App.Data.UserData;
};
export type ProjectFullData = {
pid?: string;
name: string;
created_at?: string;
due_date: string;
deadline?: string;
status?: string;
description?: string;
contact_id?: string | number;
contact?: App.Data.ContactData;
boards?: Array<App.Data.BoardData>;
};
export type TagData = {
id?: number;
name: Array<any> | string;
slug?: Array<any> | string;
type?: string;
order_column?: number;
};
export type TaskData = {
tid?: string;
id?: string;
name: string;
priority: string;
created_at?: string;
description?: string;
status?: string;
user?: App.Data.UserData;
assignee?: App.Data.UserData;
comments_count?: number;
files_count?: number;
board_id: number;
comments?: Array<App.Data.CommentData>;
position?: number;
assigned_to: number;
assigned_by?: number;
};
export type UserData = {
id?: number;
first_name: string;
last_name: string;
avatar_url?: string;
email?: string;
name?: string;
};
}
declare namespace App.Enums {
export type AddressType = 'home' | 'work';
export type PhoneType = 'mobile' | 'work' | 'home' | 'fax';
export type ProjectStatus = 'in_progress' | 'approved' | 'completed' | 'cancelled' | 'done';
export type Title = 'mr' | 'mrs' | 'ms' | 'sr' | 'prof' | 'dr';
}
