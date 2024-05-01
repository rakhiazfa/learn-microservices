import { IsNotEmpty, IsNumber, ValidateIf } from "class-validator";

class CreateMenuSchema {
    @IsNotEmpty()
    name: string;

    @IsNotEmpty()
    uri: string;

    @IsNumber()
    @ValidateIf((schema) => schema.order !== null || schema.order !== undefined)
    order?: number;

    @IsNumber()
    @ValidateIf((schema) => schema.order !== null || schema.order !== undefined)
    parent_id?: number;
}

export default CreateMenuSchema;
