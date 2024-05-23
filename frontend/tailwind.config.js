/** @type {import('tailwindcss').Config} */

export default {
    content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
    theme: {
        extend: {
            fontFamily: {
                inter: ["Inter", "sans-serif"],
            },
            colors: {
                dark: "#212121e6",
            },
            boxShadow: {
                xxs: "1.5px 1.5px 25px 1.5px rgba(0, 0, 0, 0.045)",
            },
        },
    },
    plugins: [],
};
