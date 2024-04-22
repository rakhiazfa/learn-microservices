import ucfirst from "@/utils/ucfirst";
import { plainToInstance } from "class-transformer";
import {
    validate as validateTransformedClass,
    ValidationError,
} from "class-validator";
export * from "class-validator";

const formatErrors = (errors: ValidationError[]): object =>
    errors.reduce((initial: any, error: ValidationError) => {
        initial[error.property] = error.constraints
            ? ucfirst(error.constraints[Object.keys(error.constraints)[0]])
            : null;

        return initial;
    }, {});

export const validate = async <T>(
    schema: new () => {},
    body: T
): Promise<{
    data: T;
    errors: object | null;
}> => {
    const transformedClass: any = plainToInstance(schema, body);
    const errors = await validateTransformedClass(transformedClass);

    return {
        data: body,
        errors: errors.length > 0 ? formatErrors(errors) : null,
    };
};
