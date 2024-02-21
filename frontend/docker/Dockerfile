FROM node:20.11.1-slim

# Arguments defined in docker-compose.yml
ARG user
ARG uid

USER node

WORKDIR /usr/src/app

EXPOSE 3000

ENV PATH /usr/src/app/node_modules/.bin:$PATH

CMD \[ -d "node_modules" \] && npm run dev || npm i && npm run dev