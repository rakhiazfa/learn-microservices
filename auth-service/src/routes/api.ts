import express, { Router } from "express";
import authController from "@/controllers/auth.controller";

const api: Router = express.Router();

api.post("/auth/signin", authController.signIn);
api.post("/auth/signup", authController.signUp);
api.post("/auth/signout", authController.signOut);

export default api;
