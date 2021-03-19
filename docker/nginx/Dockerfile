ARG VERSION=$VERSIOM

# Development image
FROM nginx:${VERSION} AS dev

# Copy nginx config file
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Prod image
FROM dev as prod

#COPY . /app
