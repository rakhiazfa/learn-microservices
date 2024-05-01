import { Service } from "typedi";
import PrismaService from "./prisma.service";
import type { Menu } from "@prisma/client";
import type CreateMenuSchema from "@/schemas/create-menu.schema";
import type UpdateMenuSchema from "@/schemas/update-menu.schema";

@Service({ global: true })
class MenuService {
    constructor(private readonly prismaService: PrismaService) {}

    async findAll(): Promise<Menu[]> {
        return [];
    }

    async create(createMenuSchema: CreateMenuSchema): Promise<Menu> {
        const { name, uri, order, parent_id } = createMenuSchema;

        const menu = await this.prismaService.menu.create({
            data: {
                name,
                uri,
                order,
                parentId: parent_id,
            },
        });

        return menu;
    }

    async findById(id: string): Promise<Menu> {
        const menu = await this.prismaService.menu.findUnique({
            where: { id: +id },
        });

        if (!menu) throw Error("Menu not found");

        return menu;
    }

    async update(
        updateMenuSchema: UpdateMenuSchema,
        id: string
    ): Promise<Menu> {
        const { name, uri, order, parent_id } = updateMenuSchema;

        const menu = this.prismaService.menu.update({
            where: { id: +id },
            data: {
                name,
                uri,
                order,
                parentId: parent_id,
            },
        });

        return menu;
    }

    async delete(id: string): Promise<Menu> {
        return await this.prismaService.menu.delete({
            where: { id: +id },
        });
    }
}

export default MenuService;
