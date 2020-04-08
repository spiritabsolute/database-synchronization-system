To run an application, use composer script:
 ```
 composer install
 composer serve
 ```
This will launch the php built-in web server.

If you are using docker, run the command:
```
docker-compose -p psr-framework up --build
```

The application will be available at http://127.0.0.1:8000


For **development mode** before build image you need add docker-compose.override.yml file.\
Just copy the file docker-compose.override.yml.dist:
```
docker-compose.override.yml.dist -> docker-compose.override.yml
```
To use **xdebug**, set the settings in the file: .docker/php/conf.d/xdebug.ini