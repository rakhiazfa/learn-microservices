import { HttpCode } from "../types/http-code";
import { HttpException } from "./exception";

export class NotFoundException extends HttpException {
    constructor(message: string) {
        super(message, HttpCode.NotFound);
    }
}
