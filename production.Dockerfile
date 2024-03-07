FROM laravelphp/vapor:php81

RUN apk --update add brotli

COPY . /var/task
