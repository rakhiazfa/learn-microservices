import { plainToInstance } from "class-transformer";
import {
    validate as validateTransformedClass,
    ValidationError,
} from "class-validator";

const formatErrors = (errors: ValidationError[]): object[] =>
    errors.map((error: ValidationError) => ({
        field: error.property,
        message: error.constraints
            ? error.constraints[Object.keys(error.constraints)[0]]
            : null,
    }));

export async function validate<T>(
    schema: new () => {},
    data: T
): Promise<{
    data: T;
    errors: object[];
}> {
    const transformedClass: any = plainToInstance(schema, data);
    const errors = await validateTransformedClass(transformedClass);

    return { data: data, errors: formatErrors(errors) };
}
