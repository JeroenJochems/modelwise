export function ProgressBar({ progress }: {  progress: number }) {
    return (
        <div className={"h-2 my-2 w-full"}>
            {!!progress && progress < 1 && (
                <div className="w-full bg-gray-100 h-2 rounded-full">
                    <div style={{width: progress * 100 + '%'}}
                         className="bg-green h-2 rounded-full"></div>
                </div>
            )}
        </div>
    )
}
