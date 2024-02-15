FROM node:alpine

WORKDIR /usr/app

COPY ./src/package.json ./

RUN npm install

EXPOSE 8010

CMD [ "npm", "run", "dev" ]