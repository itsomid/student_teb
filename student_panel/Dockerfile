FROM node:18-alpine as build-stage
WORKDIR /app
COPY package.json ./
RUN npm install --loglevel verbose
COPY . .
RUN npm run build

# production stage
FROM registry.classino.com/nginx-brotli:stable AS production-stage


# Copy built app
COPY --from=build-stage /app/dist /usr/share/nginx/html
COPY ./nginx /etc/nginx

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
