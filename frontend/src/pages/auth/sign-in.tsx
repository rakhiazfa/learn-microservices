import Button from "@/components/UI/button";
import Input from "@/components/UI/input";
import { yupResolver } from "@hookform/resolvers/yup";
import { SubmitHandler, useForm } from "react-hook-form";
import * as yup from "yup";

type Credentials = {
    email: string;
    password: string;
};

const schema = yup
    .object({
        email: yup
            .string()
            .email("Email must be a valid email")
            .required("Email is a required field"),
        password: yup
            .string()
            .required("Password is a required field")
            .min(8, "Password must be at least ${min} characters"),
    })
    .required();

const SignIn = () => {
    const {
        register,
        handleSubmit,
        formState: { errors },
    } = useForm<Credentials>({
        resolver: yupResolver(schema),
    });

    const onSubmit: SubmitHandler<Credentials> = (data: Credentials) => {
        console.log(data);
    };

    return (
        <div className="min-h-screen flex justify-center items-center">
            <div className="w-[350px] bg-white border border-gray-300 rounded-md px-7 py-10">
                <h2 className="text-xl font-semibold mb-5">Masuk</h2>
                <p className="text-[0.8rem] text-gray-600 mb-5">
                    Selamat datang, silahkan masukan kredensial anda untuk
                    melanjutkan.
                </p>
                <form
                    onSubmit={handleSubmit(onSubmit)}
                    className="grid grid-cols-1 gap-y-5"
                >
                    <Input
                        label="Email"
                        type="text"
                        placeholder="Masukan alamat email anda . . ."
                        {...register("email")}
                        error={errors.email?.message}
                    />
                    <Input
                        label="Kata Sandi"
                        type="password"
                        placeholder="Masukan kata sandi anda . . ."
                        {...register("password")}
                        error={errors.password?.message}
                    />
                    <div className="flex justify-end">
                        <Button type="submit">Sign In</Button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default SignIn;
