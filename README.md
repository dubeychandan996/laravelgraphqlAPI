 # Laravel Microservice

## Requirements
- PHP
- MySQL
- Composer
- JWT Secret

## Installation

1. Clone the repository.
2. Run `composer install`.
3. Configure `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   JWT_SECRET=your_generated_jwt_secret

## Usage

- Register and login using `/api/register` and `/api/login`.
- Use the provided JWT token in the `Authorization` header (`Bearer <token>`) for accessing `/api/products` CRUD endpoints.


## API Usage

This section covers the basic API calls for registering a user, logging in to obtain a JWT token, and creating a product using that token for authentication.

### 1. Register a New User

Use this endpoint to register a new user account.

- **Endpoint**: `POST /api/register`

**Example Request**:

```bash
curl --location 'http://localhost/micro/public/api/register' \
--header 'Content-Type: application/json' \
--data '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}'

## Expected response:
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2024-11-04T12:34:56.000000Z",
        "updated_at": "2024-11-04T12:34:56.000000Z"
    },
    "token": "your_jwt_token_here"
}

```
## Log In to Get JWT Token
Log in with your registered email and password to receive a JWT token for authenticating further requests.

Endpoint: POST /api/login
### Example Request:
```
curl --location 'http://localhost/micro/public/api/login' \
--header 'Content-Type: application/json' \
--data '{
    "email": "john@example.com",
    "password": "password123"
}'

Response:
{
    "token": "your_jwt_token_here"
}
```
## Create a Product (Authenticated Request)
```
curl --location 'http://localhost/micro/public/api/products' \
--header 'Authorization: Bearer your_jwt_token_here' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "name": "Sample Product",
    "description": "This is a sample product description.",
    "price": 99.99,
    "quantity": 10
}'
```

## 4. Update a Product (Authenticated Request)

Use this endpoint to update an existing product. This request requires the `Authorization` header to be set with the `Bearer` token.

- **Endpoint**: `PUT /api/products/{id}`

**Example Request**:

```bash
curl --location --request PUT 'http://localhost/micro/public/api/products/1' \
--header 'Authorization: Bearer your_jwt_token_here' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "name": "Updated Product",
    "description": "This is an updated product description.",
    "price": 89.99,
    "quantity": 20
}'
```
## Delete a Product 
```
curl --location --request DELETE 'http://localhost/micro/public/api/products/1' \
--header 'Authorization: Bearer your_jwt_token_here' \
--header 'Accept: application/json'
```