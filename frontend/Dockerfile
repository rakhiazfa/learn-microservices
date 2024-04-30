FROM oven/bun:1 AS build

WORKDIR /app

COPY package.json .
COPY bun.lockb .

RUN bun install

COPY . .

RUN bun run build

FROM build as prerelease

COPY package.json .
COPY bun.lockb .

RUN bun install --frozen-lockfile --production

FROM nginx:stable-alpine AS production

WORKDIR /app

COPY --from=prerelease /app/node_modules /app/node_modules
COPY --from=build /app/dist /app/dist
COPY --from=build /app/package.json .
COPY default.conf /etc/nginx/conf.d/

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]