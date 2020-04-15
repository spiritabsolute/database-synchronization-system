This is a console application. For installation, you will need a docker and docker-compose.

```
git clone git@github.com:spiritabsolute/database-synchronization-system.git DatabaseSynchronizationSystem
cd DatabaseSynchronizationSystem
```

Hit up the following command to start fetching all the dependencies:
```
docker-compose up -d
``` 

Once everything is finish downloading, you can execute PHP command line application.  
In this state, you have a container with a rabbitmq and two containers with applications between 
which synchronization will occur.

In two different command line session hit up the following commands to start working with the applications on 
which db1 and db2 are located.
```
docker-compose exec db1 bash
docker-compose exec db2 bash
```
This will open a new terminal inside the container. 

To work with the application, see the list of available commands:
```
bin/app.php
```

First you need to perform migrations that create a database structure:
```
bin/app.php app:migrate
```

An example of creating an employee, viewing a list of the synchronization queue, 
starting synchronization, deleting an employee:
```
bin/app.php app:employee-create
bin/app.php app:sync-get-list
bin/app.php app:sync-produce
bin/app.php app:employee-delete
```