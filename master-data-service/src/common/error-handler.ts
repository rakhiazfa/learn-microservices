import type { NextFunction, Request, Response } from "express";
import { HttpException } from "./exceptions/exception";

export const errorHandler = (
    error: Error,
    req: Request,
    res: Response,
    next: NextFunction
) => {
    if (error instanceof HttpException) {
        return res.status(error.statusCode).json({
            message: error.message,
        });
    }

    return res.status(500).json({
        message: error.message,
    });
};
