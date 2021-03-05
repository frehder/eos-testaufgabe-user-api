
# eos.uptrade Probeaufgabe

## Aufgabe

Schreib eine einfache API (unter Nutzung des Symfony Framework), um eine Liste von Benutzern anzuzeigen, neuen Benutzer zu erstellen und einen vorhanden Benutzer zu ändern oder löschen. Ziel ist es, die Datenquelle (etwa eine Datenbank, eine XML Datei, ...) für Benutzer auszutauschen, ohne den Code berühren zu müssen, der die Datenquelle verwendet und die Antwort zurückgibt. Stelle bitte eine Dokumentation zum Konsumieren der API bereit. Es wäre großartig, wenn Du uns Deine Antwort mit einem GitHub-Link und einer kleinen ReadMe-Datei senden würdest. Viel Spaß!

## Requirements

- [composer](https://getcomposer.org/)
- [symfony cli](https://symfony.com/download)
- DB server (I used MySQL in this example)

## How to use

#### 0. Clone git repository

#### 1. Install project

```bash
$ composer install
```

#### 2. Start MySQL server

#### 3. Create file `.env.local` in project root

Content:
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/eos_testaufgabe_user_api?serverVersion=5.7"
```

#### 4. Start server

```bash
$ symfony server:start
```

#### 5. See Swagger API Documentation

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
