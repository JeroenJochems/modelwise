import Hero from "@/Components/Landing/Hero";
import LogoCloud from "@/Components/Landing/LogoCloud";
import Features from "@/Components/Landing/Features";
import Testimonials from "@/Components/Landing/Testimonials";
import Contact from "@/Components/Landing/Contact";
import { ParallaxProvider } from 'react-scroll-parallax';
import ClientFeatures from "@/Components/Landing/ClientFeatures";

type Props = {
    success?: string
}
export default function Landing({ success }: Props) {

    return (
        <ParallaxProvider>
            <Hero />
            <Features />
            <ClientFeatures />
            <Testimonials />
            <LogoCloud />
            <Contact successMessage={success} />
        </ParallaxProvider>
    );
}
