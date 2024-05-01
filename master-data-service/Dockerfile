FROM oven/bun:1 AS build

WORKDIR /app

COPY package.json .
COPY bun.lockb .

RUN bun install --production

COPY . .

RUN bun run build
RUN bunx prisma generate --schema=/app/prisma/schema.prisma

FROM build AS production

WORKDIR /app

COPY --from=build /app/node_modules /app/node_modules
COPY --from=build /app/dist /app/dist
COPY --from=build /app/prisma /app/prisma
COPY --from=build /app/package.json .

EXPOSE 3000
CMD ["bun", "run", "start"]