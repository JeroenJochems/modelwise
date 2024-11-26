import {P} from "@/Components/Typography/p";
import {H3} from "@/Components/Typography/H3";
import {JobHeader} from "@/Components/JobHeader";
import DashboardLayout from "@/Layouts/DashboardLayout";
import {Content} from "@/Layouts/DashboardLayout/Content";
import {PhotoScroller} from "@/Components/Atoms/JobScroller";
import {JobSpecifics} from "@/Components/Molecules/JobSpecifics";
import {ApplyFooter} from "@/Components/Molecules/ApplyFooter";
import {DashboardFooter} from "@/Components/Molecules/DashboardFooter";
import {Tab, TabList, TabPanel, Tabs} from 'react-tabs';
import {Bubbles} from "@/Components/Atoms/JobHeader/Bubbles";
import {Bubble} from "@/Components/Atoms/JobHeader/Bubbles/Bubble";
import {CalendarDays} from "@/Components/Icons/CalendarDays";
import {formatDate} from "@/Utils/Dates";
import {Globe} from "@/Components/Icons/Globe";
import {ApplicationStatus} from "@/Components/Molecules/ApplicationStatus";
import {CurrencyEuroIcon} from "@heroicons/react/24/outline";
import {formatCents} from "@/Utils/Money";
import {Train} from "@/Components/Icons/Train";
import {useCdnLink} from "@/Hooks/useCdnLink";
import {ModelRoleViewModel} from "@/types/generated";

type Props = {
    viewModel: ModelRoleViewModel
}

export default function Show({ viewModel }: Props)
{
    const { role, hasApplied } = viewModel;
    const { job } = role;
    const cdnLink = useCdnLink();

    const tabClasses = "outline-none w-1/2 sm:w-1/2 text-center  cursor-pointer text-lg py-4 border-r border-white ";

    return (
        <DashboardLayout footer={
            !hasApplied &&
                <DashboardFooter>
                    <ApplyFooter viewModel={viewModel}/>
                </DashboardFooter>
        }>
            <div className={"flex-grow"}>

                <div className={""}>
                    <JobHeader viewModel={viewModel} />

                    <Tabs selectedTabClassName={"border-b-4 border-b-teal border-r-0"}>

                        <TabList className={`${!hasApplied && "hidden"} border-b mb-8 flex`}>
                            { hasApplied && <Tab className={tabClasses}>Your application</Tab> }
                            <Tab className={tabClasses}>Job details</Tab>
                        </TabList>

                        <TabPanel>
                            <Content>
                                <div className={"grid gap-4"}>
                                <P className={"whitespace-pre-wrap"} lineClamp={10}>{ role.description }</P>

                                <div>
                                    <H3>Fee</H3>
                                    <P>{`${formatCents(role.fee)}`} + {`${formatCents(role.buyout)}`} buyout</P>
                                </div>

                                {!!role.travel_reimbursement_note && (
                                    <div>
                                        <H3>Travel reimbursement</H3>
                                        <P>{ role.travel_reimbursement_note }</P>
                                    </div>
                                )}

                                {!! role.start_date && (
                                    <div>
                                        <H3>Shoot</H3>
                                        <P>
                                            { formatDate(role.start_date!) }<br />
                                            { job?.location }
                                        </P>
                                    </div>
                                )}

                                { !!role.buyout_note && (
                                    <div>
                                        <H3>Usage</H3>
                                        <P className={"whitespace-pre-wrap"}>{ role.buyout_note }</P>
                                    </div>
                                )}

                                { !!job.look_and_feel_photos && job.look_and_feel_photos.length > 0 && (
                                    <div className={"grid gap-4"}>
                                        <H3>Shoot look & feel</H3>
                                        <PhotoScroller photos={job.look_and_feel_photos.map(photo => cdnLink(photo.path))} />
                                    </div>
                                )}

                                { !!role.public_photos && role.public_photos.length > 0 && (
                                    <div className={"grid gap-4"}>
                                        <H3>For this role</H3>
                                        <PhotoScroller photos={role.public_photos.map(photo => cdnLink(photo.path))} />
                                    </div>
                                )}

                                <div>
                                    <H3>About the job</H3>
                                    <P>{ job.description }</P>
                                </div>

                                { !!job.brand?.name && !!job.brand?.description && (
                                    <div className={"w-full mb-8"}>
                                        <H3>About { job.brand.name }</H3>
                                        <P className={"w-full"}>
                                            { !!job.brand?.logo && <img className={"ml-4 mb-4 float-right"} src={`${job.brand.logo}?twic=v1/resize=240`} /> }
                                            { job.brand.description }
                                        </P>
                                    </div>
                                )}
                                </div>
                            </Content>
                        </TabPanel>
                    </Tabs>
                </div>
            </div>
        </DashboardLayout>
    )
}
