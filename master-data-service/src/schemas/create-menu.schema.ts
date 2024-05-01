import { IsNotEmpty, IsNumber, IsOptional, ValidateIf } from "class-validator";

class CreateMenuSchema {
    @IsNotEmpty()
    name: string;

    @IsNotEmpty()
    uri: string;

    @ValidateIf((schema) => schema.order !== null || schema.order !== undefined)
    @IsNumber()
    @IsOptional()
    order?: number;

    @ValidateIf(
        (schema) => schema.parent_id !== null || schema.parent_id !== undefined
    )
    @IsNumber()
    @IsOptional()
    parent_id?: number;
}

export default CreateMenuSchema;
