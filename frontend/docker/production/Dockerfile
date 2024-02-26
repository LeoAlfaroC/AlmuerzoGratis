FROM node:20.11.1-slim

# Arguments defined in docker-compose.yml
ARG user
ARG uid

USER node

WORKDIR /usr/src/app

EXPOSE 3000

CMD npm run build && node .output/server/index.mjs