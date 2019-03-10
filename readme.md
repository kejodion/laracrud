## Laracrud

A simple admin CRUD package for Laravel 5.8.

**Screenshots:** https://imgur.com/a/rAWwEvu

**Features:**

- CRUD command for rapid resource generating (controller, model, migrations, views, routes)
- User role-based resource paths and permissions
- User CRUD built in
- Laravel login auth integration
- Datatables integration
- Dynamic model fillables based on model table columns
- Easily extendable controllers
- AJAX form validation
- Fully responsive (Bootstrap 4)
- & more

### Installation

This package works best with a clean Laravel install, but can be used with an existing one as well.

1. Configure your `.env` file with your app name, URL, database, etc.
2. Set your app timezone in `config/app.php` (recommended but not required).
3. Require Laracrud via composer: `composer require kjjdion/laracrud`

### Configuration

If you are installing on a clean Laravel 5.8 app, use the `--force`:

    php artisan vendor:publish --provider="Kjjdion\Laracrud\Providers\LaracrudServiceProvider" --tag="install" --force

If you are installing on an existing Laravel 5.8 app, do not use the `--force`:

    php artisan vendor:publish --provider="Kjjdion\Laracrud\Providers\LaracrudServiceProvider" --tag="install"
    
If you [didn't](https://www.youtube.com/watch?v=WWaLxFIVX1s) use the `--force`, you will also have to make the following modifications:

1. Add the `ColumnFillable` trait to your `User` model.
2. Empty the contents of `css/app.css` and `js/app.js` to avoid conflicts.
2. Redirect the default `/` route to login: `Route::redirect('/', 'login')`
3. Remove the default laravel auth routes if they exist.

**Tip:** you can change the default Fontawesome logo icon class in the `laracrud.php` config file.

### Migration

Once you are done installation & configuration, run the migrations: `php artisan migrate`

## Modifying Layouts

All of the layout files used by the package are located in `resources/views/vendor/laracrud/layouts*`. You can make any changes you want in these files.

## Extending Controllers

If you want to modify the default package controllers, simply create your own controllers which extend the package controllers, and then update the `laracrud.php` config file with your new controller paths.

## User Roles Concept

User roles can be modified in the `laracrud.php` config file. Any time you generated CRUD for a new role you should add said role to the `roles` array.

The concept is simple, each role has it's own controllers, views, & routes in order to separate the concerns/permissions of each role.

All role resource namespaces/paths are prepended with the name of said role, for example, the admin role resources are located in:

- `App\Http\Controllers\Admin`
- `resources/views/admin`
- `route('admin.model.*')`

## CRUD Generator

You can use the CRUD command to create the controller, model, migrations, views, and routes for new resources. This saves a ton of time and hassle.

To generate new resources, run: `php artisan make:crud "Role Name" "Model Name"`

The role name will be used for the controller namespace, view, & route paths. **If it contains multiple words, make sure you use quotation marks and spaces.** Same goes for the model name.