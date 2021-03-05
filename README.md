
# eos.uptrade Probeaufgabe

## Aufgabe

Schreib eine einfache API (unter Nutzung des Symfony Framework), um eine Liste von Benutzern anzuzeigen, neuen Benutzer zu erstellen und einen vorhanden Benutzer zu ändern oder löschen. Ziel ist es, die Datenquelle (etwa eine Datenbank, eine XML Datei, ...) für Benutzer auszutauschen, ohne den Code berühren zu müssen, der die Datenquelle verwendet und die Antwort zurückgibt. Stelle bitte eine Dokumentation zum Konsumieren der API bereit. Es wäre großartig, wenn Du uns Deine Antwort mit einem GitHub-Link und einer kleinen ReadMe-Datei senden würdest. Viel Spaß!

## Requirements

- [composer](https://getcomposer.org/)
- [symfony cli](https://symfony.com/download)
- DB server (I used MySQL in this example)

## How to use

#### 1. Start MySQL server

#### 2. Clone git repository

```bash
$ git clone git@github.com:frehder/eos-testaufgabe-user-api.git
$ cd eos-testaufgabe-user-api
```

#### 3. Create `.env.local`

Duplicate sample:
```bash
cp .env.local.sample .env.local
```

Replace USER, PASSWORD and DATABASENAME in `.env.local`

#### 4. Install project

```bash
$ composer install
```

#### 5. Run DB migration

```bash
$ php bin/console doctrine:migrations:migrate
```

#### 6. Start server

```bash
$ symfony server:start
```

#### 7. See Swagger API Documentation in browser

[http://127.0.0.1:8000/api/doc](http://127.0.0.1:8000/api/doc)

---

## Endpoints

### GET `/api/v1/users`

Fetch a list of all users.

### GET `/api/v1/user/{userId}`

Fetch a specific user by ID.

### POST `/api/v1/user`

Create a new user.

Header:
```
Content-Type application/json
```

Body:
```
{
    "email": "max.mustermann@musterfirma.de",
    "firstname": "Max",
    "lastname": "Mustermann"
}
```

### DELETE `/api/v1/user/{userId}`

Delete an existing user by ID.

### PATCH `/api/v1/user/{userId}`

Partially update one or more fields of an existing user.

Header:
```
Content-Type application/json
```

Body:
```
{
    "email": "maximilian.mustermann@musterfirma.de",
    "name": "Maximilian"
}
```
