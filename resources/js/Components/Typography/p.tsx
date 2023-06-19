type Props = {
    children: React.ReactNode
}

export function P({children}: Props) {
    return (
        <p className="text-gray-600 text-sm">
            {children}
        </p>
    )
}
