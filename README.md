API v1
=======
# sawmill-warehouse
pet project

# Requirements:
php 5.6, mysql 5.6, elasticsearch 2.2. Symfony 2.7, doctrine 2.5

# Deployment
* git clone ....
* composer install
* set your database connection parameters
* set auth_token_value
* execute in console `app/console doctrine:migrations:migrate`
* start built-id symfony web server
* start using REST Api

## Colors:
```
GET /api/colors/{id} - return one color
GET /api/colors - return all colors
DELETE /api/colors/{id}?token={auth_token_value} - delete color with id = {id}
POST /api/colors?token={auth_token_value} - required body {"name": "<color name>"}
```

## Materials:
```
GET /api/materials/{id} - return one material
GET /api/materials - return all materials
DELETE /api/materials/{id}?token={auth_token_value} - delete material with id = {id}
POST /api/materials?token={auth_token_value} - required body {"name": "<material name>"}
```

## Planks
```
GET /api/planks/{id} - return one plank
GET /api/planks[?keyword=term] - return all planks if get params are empty and return all planks which {keyword}-field value equals {term}
DELETE /api/planks/{id}?token={auth_token_value} - delete plank with id = {id}
POST /api/planks?token={auth_token_value} - required body
PUT /api/planks?token={auth_token_value} - required body
```

### POST and PUT body example

```
JSON
{
    "id": "4"
    "material": "oak",
    "color": "yellow",
    "length": 111,
    "height": 0.111,
    "width": 1.111,
    "quantity": 111,
}
```
