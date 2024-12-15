# EspritNest

EspritNest is a colocation website for Esprit students.

## How to Run the Project

### Install Dependencies
To install the necessary dependencies, run the following command:
```
composer install
```

### Configure the Database
Update the `.env` file with your database configuration:
```
DATABASE_URL="mysql://username:password@127.0.0.1:3306/dbname"
```

### Run Doctrine Migrations
To run the Doctrine migrations, use the following command:
```
php bin/console doctrine:migrations:migrate
```

### Run the Project
To start the project, use the following command:
```
symfony server:start
```