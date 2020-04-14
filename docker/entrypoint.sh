#!/bin/sh

ln -sr $APP/migrations db/migrations
ln -sr $APP/src/App/Entity src/App/Entity

touch logs/application.log
tail -f logs/application.log