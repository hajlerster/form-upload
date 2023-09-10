# Instalacja

w pliku php.ini odkomentować linię:
```
extension=pdo_pgsql
```

Uruchomić docker-compose up -d

Polecenie php bin/console doctrine:database:create tworzy bazę danych o nazwie: app, lecz po docker compose up -d baza powinna się utowożyć sama.

Utworzona została encja UserWithImage

Przeprowadzona migracja 

```bash
php bin/console make:migration
```

Następnie należy uruchomić migrację

```bash
php bin/console doctrine:migrations:migrate
```

w katalogu public musi istnieć katalog uploads i musi mieć prawa zapisu danych
```bash
mkdir public/uploads
```