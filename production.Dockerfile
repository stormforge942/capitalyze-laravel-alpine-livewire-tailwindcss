# FROM laravelphp/vapor:php82-arm

# RUN apk add --no-cache brotli

# COPY . /var/task

FROM laravelphp/vapor:php82

RUN apk add --no-cache brotli

COPY . /var/task
