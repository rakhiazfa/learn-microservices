import { validate } from "@/common/validator";
import SignInDto from "@/dto/signin-dto";
import { Request, Response } from "express";

const signIn = async (req: Request, res: Response) => {
    const {
        data: {},
        errors,
    } = await validate<SignInDto>(SignInDto, req.body);

    if (errors)
        return res.status(400).json({
            errors,
        });

    res.json({
        message: "Successfully logged in.",
    });
};

const signUp = async (req: Request, res: Response) => {};

const signOut = async (req: Request, res: Response) => {};

export default {
    signIn,
    signUp,
    signOut,
};
