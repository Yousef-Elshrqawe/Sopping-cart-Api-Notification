# Laravel Shopping Cart Notification APi


## Task Requiremnts:
- Implement a shopping cart system API.
- The user can create a cart with or without login
- The user can list products.
- The user can add products to the cart.
- The user can checkout by submitting their: name, address, and payment details.
- The order should be save with unique Id.
- If the user is logged in, the order should be linked to them.
- The user can list their previous orders.
- Admin can send notifications via mail, application, or SMS
- Messages can be sent to one client or all clients

# API documentation:
All API End points and documentation can be found at:
[This link](https://elements.getpostman.com/redirect?entityId=22137553-e6a4cf0c-00a8-4df8-aaac-bff1364de94f&entityType=collection).

The following is just a simple list of the api end points:

>POST /api/auth/signup

>POST /api/auth/login

>GET /api/auth/logout

>GET /api/products/

>GET /api/products/:id

>POST /api/carts/

>GET /api/carts/:CartToken

>POST /api/carts/:CartToken

>POST /api/carts/:CartToken/checkout

>DEL /api/carts/:CartToken

>GET /api/orders

>GET /api/orders/:orderID


# Installation

Install the dependencies and start the server to test the Api.

```sh
$ Composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
$ php artisan db:seed
```

