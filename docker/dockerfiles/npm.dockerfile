FROM node:22.14

WORKDIR /app

RUN ls
COPY app/package.json ./
RUN npm install

COPY . .

CMD ["npm", "run", "dev"]