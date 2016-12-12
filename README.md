# redix
A very simple Redis migration

Redix is created based on Phinx.

a file named redix.yml has to be created and placed in the root of your working directory
- migrationPath: app/migrations
- host: 127.0.0.1
- port: 6379

bin/redix create ProjectName to create a migration file under app/migrations
bin/redix migrate to insert the value into redis
bin/redix rollback to rollback a single migration. Rollback follows a FILO process.

