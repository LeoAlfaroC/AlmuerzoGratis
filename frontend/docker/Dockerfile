FROM node:20.11.1-alpine3.19

# Arguments defined in docker-compose.yml
ARG user
ARG uid

USER node

WORKDIR /usr/src/app

EXPOSE 5173

CMD \[ -d "node_modules" \] && npm run dev || npm i && npm run dev