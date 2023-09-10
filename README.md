# Project Setup
This project is built on the Symfony 6.3.4 framework. It allows users to work with a UserWithImage entity, providing functionality to upload, edit, and manage user data and images.

### Prerequisites
Ensure the pdo_pgsql extension is enabled in your php.ini file:


```ini
extension=pdo_pgsql
```
Docker should be installed and running.

### Installation
Start Docker Services:

```bash
docker-compose up -d
```
Post the above command, the database named app should be automatically created. If for some reason it doesn't, you can manually create it with:

```bash
php bin/console doctrine:database:create
```
### Migration:

First, create a migration:

```bash
php bin/console make:migration
```
Then, execute the migration:

```bash
php bin/console doctrine:migrations:migrate
```
### Setup Upload Directory:

Ensure the uploads directory exists within the public folder and has write permissions:

```bash
chmod 777 public/uploads
mkdir public/uploads
```
# About the Project
The primary form utilizes raw HTML, while the data editing module in the admin panel is powered by Symfony Form. A notable entity, UserWithImage, has been introduced which helps in managing user data along with their associated images.

