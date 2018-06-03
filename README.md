# trve-shop

This project uses Laravel 5.6, PostgreSQL and Docker and can be found on GitHub: https://github.com/derhofbauer/trve-shop.

## Getting started

This project uses Docker and Docker Compose to provide an easy and quick way to bring up a development environment.

Just install Docker Compose and run `docker-compose up` in the root directory of this project and a Docker Container
will start on `localhost:1236/public` and populate the database with test data. The backend can be found on `localhost:1236/public/admin`. 

If you cannot use this method for some reason, there is a PostgreSQL database dump available in `./setup`.

## Credentials

The database credentials can be found within the `docker-compose.yml` and `docker.env` files.

There is a backend user `admin` with password `password` and a frontend user `arthur.dent@galaxy.com` with password
`password`. These two users are created within the Laravel migration and seeding process.

## Migration & Seeding

When using Docker Compose all migrations and seeders are run automatically. You can run them manually using one of the
following commands:

```bash
composer migration-fresh
// or
php artisan migrate:fresh --seed
```

## Database

Most tables are self-explanatory, however there are a few traits that need explanations.

All system tables use the prefix `sys_`. This makes it easier to implement plugin functionality at some point in the future.

+ `sys_address.address_line_2` is a simple text field for additional address information
+ `sys_blog_entry.media` is a JSON field holding a serialized array of image paths. This is the same on all `media` columns.
+ `sys_blog_product_mm` is a simple mapping table to provide n:m relationships between blog entries and products. This is the same with all `_mm` tables.
+ `sys_order.invoice` is a TEXT field holding serialized product objects and quantities. This makes it possible to
    re-create an order at any time using the exact state a product had, when it was ordered. We do this because a product
    might change over time, prices change etc. It is possible to achieve the same effect using product versions.
+ `sys_order.delivery_address` holds a serialized address object or any other address. This makes it possible to input a
    custom delivery address during the checkout process or in the backend.
+ `sys_order.payment_method` holds a serialized payment method object to store the state and be able to reproduce it at
    any time, just like with the `invoice` column.
+ `sys_product.parent_product_id` references another product and enables inheritance functionality on products
+ `sys_role` has a field for each permission in the system. Those are not fully utilized at the moment.

## Architecture

Besides the usual Laravel architecture we use 3 different views for the backend and lots of views for the frontend.

In the backend all controllers implement the same interface and use the same views. Those views are controlled using a
rather complex config array. This can be observed in all `./src/app/Http/Controllers/Backend/*Controller.php` files. This
concept is possible because we only have a few types of views.

In the frontend we cannot use this architecture and therefore have more views but less controllers, because we have fewer
use-cases. Frontend controllers are stored in `./src/app/Http/Controllers/Frontend` and `./src/app/Http/Controllers/Auth`.
The whole cart management and checkout logic is implemented within the `CartController`. The profile views are created in
the `ProfileController`.
We got a `FilterController` to handle search, category and price filtering. 

We do not use custom middleware but a few custom helper classes to provide easy access to common configurations.

Another thing worth noticing is that we seperate users into frontend and backend users. Therefore we have to different
authentication guards: `web` and `admin`. Configuration can be found in `./src/config/auth.php`.

### LESS

Laravel comes with Sass Sample Stylesheets, but we use LESS to get rid of another dependency (i. e. Ruby).

Run `grunt watch` the `./Build` directory to automatically build all CSS and JS files. This combines all JS dependencies
into one single file and compiles, prefixes and minifies our LESS code into one `frontend.min.css` and one `backend.min.css`.