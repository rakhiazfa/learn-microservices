import express, { Express, Request, Response } from "express";
import helmet from "helmet";
import cors from "cors";
import morgan from "morgan";
import api from "./routes/api";
import "reflect-metadata";
import { dataSource } from "./providers/database";

dataSource
    .initialize()
    .then(() => {
        console.log("Data Source has been initialized.");
    })
    .catch((err) => {
        console.error("Error during Data Source initialization : ", err);
    });

const app: Express = express();
const port: number = 3000;

app.use(cors());
app.use(helmet());
app.use(morgan("dev"));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.get("/", (req: Request, res: Response) => {
    res.json({
        service: {
            name: "Auth Service",
            framework: "Express JS",
        },
    });
});
app.use("/api", api);

app.listen(port, () => {
    console.log(`Server started at http://localhost:${port}`);
});
