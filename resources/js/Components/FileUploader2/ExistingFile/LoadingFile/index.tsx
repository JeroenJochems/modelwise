import React from "react";

export const LoadingFile = ({ src, className }: { src: string, className: string }) => {
    const imgEl = React.useRef<HTMLImageElement>(null);

    const image = new Image();
    image.src = src;

    const [loaded, setLoaded] = React.useState(image.complete || (image.width + image.height) > 0);

    const onImageLoaded = () => setLoaded(true);

    React.useEffect(() => {
        const imgElCurrent = imgEl.current;

        if (imgElCurrent) {
            imgElCurrent.addEventListener('load', onImageLoaded);
            return () => imgElCurrent.removeEventListener('load', onImageLoaded);
        }
    }, [imgEl]);

    return (
        <>
            <p className={"flex rounded text-teal text-center justify-center items-center aspect-square bg-teal-100 border border-gray-400"}
               style={!loaded ? { display: 'flex' } : { display: 'none' }}>
                <svg className="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                    <path className="opacity-50" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </p>
            <img
                ref={imgEl}
                src={src}
                className={className}
                style={loaded ? { display: 'inline-block' } : { display: 'none' }}
            />
        </>
    );
};
