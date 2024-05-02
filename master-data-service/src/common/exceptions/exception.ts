import type { HttpCode } from "../types/http-code";

export class Exception extends Error {
    public readonly message: string;

    constructor(message: string) {
        super(message);

        this.message = message;

        Object.setPrototypeOf(this, new.target.prototype);
        Error.captureStackTrace(this);
    }
}

export class HttpException extends Exception {
    public readonly message: string;
    public readonly statusCode: HttpCode;

    constructor(message: string, statusCode: HttpCode) {
        super(message);

        this.message = message;
        this.statusCode = statusCode;

        Object.setPrototypeOf(this, new.target.prototype);
        Error.captureStackTrace(this);
    }
}
