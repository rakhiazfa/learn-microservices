import { IsEmail, IsNotEmpty } from "class-validator";

class SignInDto {
    @IsEmail()
    @IsNotEmpty()
    email: string;

    @IsNotEmpty()
    password: string;
}

export default SignInDto;
