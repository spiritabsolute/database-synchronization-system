#!/bin/sh

ln -srT $APP/config/autoload/app.local.php config/autoload/app.local.php
ln -srT $APP/migrations db/migrations
ln -srT $APP/src/App/Entity src/App/Entity
ln -srT $APP/src/App/CustomCommand src/App/CustomCommand
ln -srT $APP/config/autoload/custom.global.php config/autoload/custom.global.php

touch logs/application.log
tail -f logs/application.log