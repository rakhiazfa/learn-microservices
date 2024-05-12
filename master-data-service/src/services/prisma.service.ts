import { Prisma, PrismaClient } from "@prisma/client";
import { Service } from "typedi";

@Service()
class PrismaService extends PrismaClient {
    constructor(
        optionsArg?:
            | Prisma.Subset<
                  Prisma.PrismaClientOptions,
                  Prisma.PrismaClientOptions
              >
            | undefined
    ) {
        super(optionsArg);
    }
}

export default PrismaService;
