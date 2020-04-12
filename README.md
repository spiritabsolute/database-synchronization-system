```
git clone git@github.com:spiritabsolute/database-synchronization-system.git DatabaseSynchronizationSystem
cd DatabaseSynchronizationSystem
```

//todo use docker with full settings
```

```

For creating databases use commands:
```
vendor/bin/phinx migrate -c db1.php
vendor/bin/phinx migrate -c db2.php
```

This is a console application. To work with the application, input the command:
```
bin/app.php

Available commands:
  help                 Displays help for a command
  list                 Lists commands
 app
  app:create-employee  Creates a new employee

```