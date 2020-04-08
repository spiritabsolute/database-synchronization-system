//todo use docker with full settings

To run an application, use composer script:
 ```
 composer install
 composer serve
 ```
This will launch the php built-in web server.

The application will be available at http://127.0.0.1:8000

Commands for multiple migrations:
```
vendor/bin/phinx create -c db1.php Init
vendor/bin/phinx create -c db2.php Init

vendor/bin/phinx migrate -c db1.php
vendor/bin/phinx migrate -c db2.php
```