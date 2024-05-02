import { IsNotEmpty, IsNumber, IsOptional, IsString } from "class-validator";

class UpdateMenuSchema {
    @IsNotEmpty()
    name: string;

    @IsString()
    @IsOptional()
    uri?: string;

    @IsNumber()
    @IsOptional()
    order?: number;

    @IsNumber()
    @IsOptional()
    parentId?: number;
}

export default UpdateMenuSchema;
