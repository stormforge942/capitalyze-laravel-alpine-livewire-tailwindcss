FROM laravelphp/vapor:php82-arm

RUN apk add --no-cache brotli

COPY . /var/task
