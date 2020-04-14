FROM php:7.2-cli

ARG APP=""

ENV APP $APP

WORKDIR app

COPY entrypoint.sh /

ENTRYPOINT ["/entrypoint.sh"]