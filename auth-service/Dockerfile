FROM node:18-alpine as builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

FROM node:18-alpine as production

WORKDIR /app

COPY package*.json ./
COPY .env* ./

RUN npm install --production

COPY --from=builder ./app/dist ./dist

EXPOSE 3000
CMD ["npm", "run", "start"]