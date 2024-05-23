type ButtonProps = React.DetailedHTMLProps<
    React.ButtonHTMLAttributes<HTMLButtonElement>,
    HTMLButtonElement
> & {
    color?: "primary" | "secondary" | "dark";
};

const colors = {
    primary: "bg-blue-500 hover:bg-blue-600 text-white",
    secondary: "bg-emerald-600 hover:bg-emerald-700 text-white",
    dark: "bg-gray-800 hover:bg-gray-900 text-white",
};

const Button = ({ children, type, onClick, color }: ButtonProps) => {
    const selectedColor = color ? colors[color] : colors.primary;

    return (
        <button
            type={type}
            onClick={onClick}
            className={`
                flex justify-center items-center 
                text-xs font-medium tracking-wide 
                rounded-sm px-5 py-2 
                transition-all duration-200
                ${selectedColor}
            `}
        >
            {children}
        </button>
    );
};

export default Button;
