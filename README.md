## Installation

1. composer install
2. set database credentials in .env file
`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`
3. php bin/console doctrine:migrations:migrate
4. npm install
5. ./node_modules/.bin/encore production
6. sudo php bin/console server:run
7. http://127.0.0.1:8000