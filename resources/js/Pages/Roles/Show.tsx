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
    const { role, isHired, hasApplied, isInvited } = viewModel;
    const { job } = role;
    const cdnLink = useCdnLink();

    console.log(viewModel);

    const tabClasses = "outline-none w-1/2 sm:w-1/2 text-center  cursor-pointer text-lg py-4 border-r border-white ";

    return (
        <DashboardLayout footer={
            !hasApplied &&
                <DashboardFooter>
                    <ApplyFooter viewModel={viewModel}/>
                </DashboardFooter>
        }>
            <div className={"flex-grow"}>

                <JobHeader viewModel={viewModel} />

                <Tabs selectedTabClassName={"border-b-4 border-b-teal border-r-0"}>

                    <TabList className={`${!hasApplied && "hidden"} border-b mb-8 flex`}>
                        { hasApplied && <Tab className={tabClasses}>Your application</Tab> }
                        { isHired && <Tab className={tabClasses}>Your role</Tab> }
                        <Tab className={tabClasses}>Job details</Tab>
                    </TabList>

                    { hasApplied && (
                        <TabPanel>
                            <ApplicationStatus viewModel={viewModel} />
                        </TabPanel>
                    )}

                    <TabPanel>
                        <Content>
                            <P className={"whitespace-pre-wrap"} lineClamp={10}>{ role.description }</P>

                            <div className={"hidden sm:block"}>
                                <JobSpecifics role={role} />
                            </div>

                            <div className={"sm:hidden"}>
                                <Bubbles>
                                    <Bubble className={"mr-2"}>
                                        <CalendarDays className={"mr-1"} /> { formatDate(role.start_date) }
                                    </Bubble>

                                    <Bubble>
                                        <Globe className={"mr-1"} /> { job.location }
                                    </Bubble>

                                    <Bubble>
                                        <CurrencyEuroIcon className={"h-6 w-6 mr-1"} />
                                        {`${formatCents(role.fee)}`} + {`${formatCents(role.buyout)}`}
                                    </Bubble>

                                    <Bubble>
                                        <Train className={"h-5 w-5 m-1 mr-1"} />
                                        { role.travel_reimbursement_note }
                                    </Bubble>
                                </Bubbles>
                            </div>

                            { !!role.buyout_note && (
                                <div>
                                    <H3>Usage</H3>
                                    <P className={"whitespace-pre-wrap"}>{ role.buyout_note }</P>
                                </div>
                            )}

                            { job.look_and_feel_photos.length > 0 && (
                                <div className={"mt-4 grid gap-4"}>
                                    <H3>Shoot look & feel</H3>
                                    <PhotoScroller photos={job.look_and_feel_photos.map(photo => cdnLink(photo.path))} />
                                </div>
                            )}

                            { role.public_photos.length > 0 && (
                                <div className={"mt-4 grid gap-4"}>
                                    <H3>For this role</H3>
                                    <PhotoScroller photos={role.public_photos.map(photo => cdnLink(photo.path))} />
                                </div>
                            )}

                            <div className={"mt-4"}>
                                <H3>About the job</H3>
                                <P>{ job.description }</P>
                            </div>

                            { !!job.brand?.name && !!job.brand?.description && (
                                <div className={"w-full mt-4 mb-8"}>
                                    <H3>About { job.brand.name }</H3>
                                    <P className={"w-full"}>
                                        { !!job.brand?.logo && <img className={"ml-4 mb-4 rounded-lg float-right"} src={`${job.brand.logo}?h=120`} /> }
                                        { job.brand.description }
                                    </P>
                                </div>
                            )}
                        </Content>
                    </TabPanel>
                </Tabs>
            </div>
        </DashboardLayout>
    )
}
