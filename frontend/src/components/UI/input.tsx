import { forwardRef, Ref, useId } from "react";

type InputProps = React.DetailedHTMLProps<
    React.InputHTMLAttributes<HTMLInputElement>,
    HTMLInputElement
> & { label?: string; error?: string; inputClassName?: string };

const Input = (
    {
        label,
        type,
        name,
        value,
        onChange,
        className,
        inputClassName,
        placeholder,
        error,
    }: InputProps,
    ref: Ref<HTMLInputElement>
) => {
    const id = useId();

    return (
        <div className={className}>
            <label
                htmlFor={id}
                className="block text-xs font-medium tracking-wide mb-2"
            >
                {label}
            </label>
            <input
                ref={ref}
                type={type}
                id={id}
                name={name}
                value={value}
                onChange={onChange}
                className={`
                    block w-full outline-none text-xs 
                    border border-gray-300 rounded-sm 
                    px-3 py-2 
                    ${inputClassName ?? ""}
                `}
                placeholder={placeholder}
            />
            {error ? (
                <span className="text-xs text-red-500 ml-1 mt-2">{error}</span>
            ) : null}
        </div>
    );
};

export default forwardRef<HTMLInputElement, InputProps>(Input);
