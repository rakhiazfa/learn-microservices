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

const cleanData = (data: any): any => {
    if (data === null) {
        return undefined;
    }

    if (Array.isArray(data)) {
        return data.map((item) => cleanData(item));
    }

    if (typeof data === "object") {
        const result: any = {};

        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                result[key] = cleanData(data[key]);
            }
        }

        return result;
    }

    return data;
};

export async function validate<T>(
    schema: new () => {},
    data: T
): Promise<{
    data: T;
    errors: object[];
}> {
    data = cleanData(data) as T;

    const transformedClass: any = plainToInstance(schema, data);
    const errors = await validateTransformedClass(transformedClass);

    return { data: data, errors: formatErrors(errors) };
}
