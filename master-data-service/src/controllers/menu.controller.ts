import { Service } from "typedi";
import { type NextFunction, type Request, type Response } from "express";
import MenuService from "@/services/menu.service";
import { validate } from "@/common/validator";
import CreateMenuSchema from "@/schemas/create-menu.schema";
import UpdateMenuSchema from "@/schemas/update-menu.schema";

@Service()
class MenuController {
    constructor(private readonly menuService: MenuService) {}

    async findAll(req: Request, res: Response, next: NextFunction) {
        try {
            const menus = await this.menuService.findAll();

            res.json({
                menus,
            });
        } catch (error) {
            next(error);
        }
    }

    async create(req: Request, res: Response, next: NextFunction) {
        try {
            const { data, errors } = await validate<CreateMenuSchema>(
                CreateMenuSchema,
                req.body
            );

            if (errors.length > 0) {
                return res.status(400).json({
                    errors,
                });
            }

            this.menuService.create(data);

            res.status(201).json({
                message: "Successfully created a new menu",
            });
        } catch (error) {
            next(error);
        }
    }

    async findById(req: Request, res: Response, next: NextFunction) {
        try {
            const { id } = req.params;

            const menu = await this.menuService.findById(id);

            res.json({
                menu,
            });
        } catch (error) {
            next(error);
        }
    }

    async update(req: Request, res: Response, next: NextFunction) {
        try {
            const { id } = req.params;
            const { data, errors } = await validate<UpdateMenuSchema>(
                UpdateMenuSchema,
                req.body
            );

            if (errors.length > 0) {
                return res.status(400).json({
                    errors,
                });
            }

            await this.menuService.update(data, id);

            res.json({
                message: "Successfully updated menu",
            });
        } catch (error) {
            next(error);
        }
    }

    async delete(req: Request, res: Response, next: NextFunction) {
        try {
            const { id } = req.params;

            await this.menuService.delete(id);

            res.json({
                message: "Successfully deleted menu",
            });
        } catch (error) {
            next(error);
        }
    }
}

export default MenuController;
