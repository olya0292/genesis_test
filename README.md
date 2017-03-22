# genesis_test
Console Symfony 3 application

#### Install

1. Make Composer install the project's dependencies into vendor/ with command `composer install`. Enter your parameters to PostgresSQL DB and others.
2. Create DB with command `php bin/console doctrine:database:create`
3. Make migrations `php bin/console doctrine:migrations:migrate`

To run the consumer we need to run command `bin/console rabbitmq:consume -w  make_api_call`

To run command, that show info about users, albums and photos you need `bin/console app:list-users`
 
Command `bin/console app:get-albums [id]` will get info about one user. If you need get IDs from local file specify option `--src` with value `file`

`bin/console app:get-albums [file_path] --src=file`