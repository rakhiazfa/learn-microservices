import "module-alias/register";
import "reflect-metadata";
import express, { type Express } from "express";
import cors from "cors";
import morgan from "morgan";
import menuRoutes from "./routes/menu.routes";
import { errorHandler } from "./common/error-handler";

async function main() {
    const app: Express = express();
    const port: number = 3000;

    app.use(cors());
    app.use(morgan("dev"));
    app.use(express.json());
    app.use(express.urlencoded({ extended: true }));

    app.use("/menus", menuRoutes);

    app.use(errorHandler);

    app.listen(port, () => {
        console.log(`Server running at http://localhost:${port}`);
    });
}

main();
