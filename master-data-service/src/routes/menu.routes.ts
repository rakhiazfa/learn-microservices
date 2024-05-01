import MenuController from "@/controllers/menu.controller";
import express, {
    type NextFunction,
    type Request,
    type Response,
    type Router,
} from "express";
import Container from "typedi";

const menuRoutes: Router = express.Router();
const menuController = Container.get(MenuController);

menuRoutes.get(
    "/",
    async (req: Request, res: Response, next: NextFunction) =>
        await menuController.findAll(req, res, next)
);
menuRoutes.post(
    "/",
    async (req: Request, res: Response, next: NextFunction) =>
        await menuController.create(req, res, next)
);
menuRoutes.get(
    "/:id",
    async (req: Request, res: Response, next: NextFunction) =>
        await menuController.findById(req, res, next)
);
menuRoutes.put(
    "/:id",
    async (req: Request, res: Response, next: NextFunction) =>
        await menuController.update(req, res, next)
);
menuRoutes.delete(
    "/:id",
    async (req: Request, res: Response, next: NextFunction) =>
        await menuController.delete(req, res, next)
);

export default menuRoutes;
