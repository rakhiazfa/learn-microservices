FROM node:18 AS build

WORKDIR /app

COPY package*.json .

RUN npm install

COPY . .

RUN npx prisma generate
RUN npm run build

FROM build as production

COPY --from=build /app/node_modules /app/node_modules
COPY --from=build /app/dist /app/dist
COPY --from=build /app/prisma /app/prisma
COPY --from=build /app/package.json .

EXPOSE 3000
CMD ["npm", "run", "start"]