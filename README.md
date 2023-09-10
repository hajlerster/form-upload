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

#### Composer install:
```bash
composer install
```



### Migration & Database Setup:
```bash
php bin/console doctrine:database:create
```
Docker should be installed and running and database should be created.

First, create a migration if made any changes in entity:

```bash
php bin/console make:migration
```
Then, execute the migration:

```bash
php bin/console doctrine:migrations:migrate
```
### Setup Upload Directory:

Ensure the uploads directory exists within the public folder and has write permissions:

If project works open /init-admin to create admin user. This is for one time only.
Default admin user is admin with password MichalRusin!23

```bash
mkdir public/uploads
chmod 777 public/uploads
```

Don't forget to change password in .env file for database connection.
Also after creating admin user, remove /init-admin from url.

Prepare nginx config file for your domain and run:
```bash
location ~ ^/index\.php(/|$) {
        # when using PHP-FPM as a unix socket
        #fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;


        # when PHP-FPM is configured to use TCP
        # fastcgi_pass 127.0.0.1:9000;

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        # optionally set the value of the environment variables used in the application
        # fastcgi_param APP_ENV prod;
        # fastcgi_param APP_SECRET <app-secret-id>;
        # fastcgi_param DATABASE_URL "mysql://db_user:db_pass@host:3306/db_name";

        # When you are using symlinks to link the document root to the
        # current version of your application, you should pass the real
        # application path instead of the path to the symlink to PHP
        # FPM.
        # Otherwise, PHP's OPcache may not properly detect changes to
        # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
        # for more information).
        # Caveat: When PHP-FPM is hosted on a different machine from nginx
        #         $realpath_root may not resolve as you expect! In this case try using
        #         $document_root instead.
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        # Prevents URIs that include the front controller. This will 404:
        # http://example.com/index.php/some-path
        # Remove the internal directive to allow URIs like this
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    # Ochrona przed dostępem do plików .htaccess
    location ~ /\.ht {
        deny all;
    }
```

# About the Project
The primary form utilizes raw HTML, while the data editing module in the admin panel is powered by Symfony Form. A notable entity, UserWithImage, has been introduced which helps in managing user data along with their associated images.

