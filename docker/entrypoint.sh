#!/bin/sh

ln -srT $APP/migrations db/migrations
ln -srT $APP/src/App/Entity src/App/Entity

touch logs/application.log
tail -f logs/application.log