import dotenv from "dotenv";

dotenv.config();

import { DataSource } from "typeorm";

export const dataSource = new DataSource({
    type: "mysql",
    host: process.env.DATABASE_HOST ?? "localhost",
    port: parseInt(process.env.DATABASE_PORT ?? "3306"),
    database: process.env.DATABASE_NAME ?? "auth_service",
    username: process.env.DATABASE_USERNAME ?? "root",
    password: process.env.DATABASE_PASSWORD ?? "",
    migrations: [__dirname + "/../migrations/**/*.{ts,js}"],
    entities: [__dirname + "/../entities/**/*.{ts,js}"],
    synchronize: false,
    logging: false,
});
