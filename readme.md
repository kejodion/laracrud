## Laracrud

A simple CRUD backend package for Laravel 5.8.

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

## Installation

This package works best with a clean Laravel install, but can be used with an existing one as well.

1. Require via composer: `composer require kjjdion/laracrud`
2. Configure your `.env` file with your app name, URL, database, etc.
3. Set your app timezone in `config/app.php` (recommended but not required).

### Configuration

If you are installing on a clean Laravel 5.8 app, use the `--force`:

    php artisan vendor:publish --provider="Kjjdion\Laracrud\Providers\LaracrudServiceProvider" --tag="install" --force

If you are installing on an existing Laravel 5.8 app, do not use the `--force`:

    php artisan vendor:publish --provider="Kjjdion\Laracrud\Providers\LaracrudServiceProvider" --tag="install"
    
If you [didn't](https://www.youtube.com/watch?v=WWaLxFIVX1s) use the `--force`, you will also have to make the following modifications:

1. Add the `ColumnFillable` trait to your `User` model.
2. Empty the contents of `public/css/app.css` and `public/js/app.js` to avoid conflicts.
2. Redirect the default `/` route to `login` in `routes/web.php`: `Route::redirect('/', 'login')`
3. Remove the default laravel auth routes if they exist.

**Tip:** you can change the default Fontawesome logo icon class in `config/laracrud.php`.

### Migration

Once you are done installation & configuration, run: `php artisan migrate`

### Logging In

Visit your app URL. You should be presented with the login screen. The default admin login is:

- Email: admin@example.com
- Password: admin123

## Making Tweaks

The package was designed to be extremely flexible and modifiable.

### Extending Controllers

If you want to modify the default package controllers, simply create your own controllers which extend the package controllers, and then update `config/laracrud.php` with your new controller paths.

### Modifying Layouts

All of the layout files used by the package are located in `resources/views/vendor/laracrud/layouts/*`. You can make any changes you want in these files. Note that any time you generate CRUD a new nav link will be inserted in the `nav` layout file automatically.

### Publishing Package Files

All package files can be published for further tweaking. The following tags are available: 

- `config`: publishes the config file
- `migrations`: publishes the migrations
- `views`: publishes all views
- `install`: publishes all necessary installation files

For example, publishing the config file:

    php artisan vendor:publish --provider="Kjjdion\Laracrud\Providers\LaracrudServiceProvider" --tag="config"

## User Roles Concept

Available user roles can be modified in `config/laracrud.php`. Any time you generate CRUD for a new role you should add said role to the `roles` array.

The concept is simple, each role has it's own controllers, views, & routes in order to separate the concerns/permissions of each role.

All role resource namespaces/paths are prepended with the name of said role, for example, the admin role resources are located in:

- `App\Http\Controllers\Admin`
- `resources/views/admin`
- `route('admin.models.*')`

You can also use the `Gate` middleware and blade directives with the role name in order ensure a user has said role e.g.:

- `@can('Admin')`
- `$this->middleware(['auth', 'can:Admin']);`

## CRUD Generator

You can use the CRUD command to create the controller, model, migrations, navbar link, views, and routes for new resources. This saves a ton of time and hassle.

To generate new resources, run: `php artisan make:crud "Role Name" "Model Name"`

The role name will be used for the controller namespace, view, & route paths. **If a role or model name contains multiple words, make sure you use quotation marks and spaces. Also, make sure you use the singular form, and not the plural.**

For example, let's say I want Admin's to have access to a new `Car` resource. I'd run `php artisan make:crud Admin Car`. Now my Admin's have access to this new resource.

The scaffolding only generates with a `name` attribute for the model. You will have to update your controller, model, migrations, views, and routes with any new attributes or functionality your app requires for the generated resource.

Once you're ready, you can `php artisan migrate` to run the migrations for your new resource.

## JSON Responses

Since all forms use AJAX, the controllers are expected to return JSON responses with specific key/value pairs e.g.:

    return response()->json([
        'flash_now' => ['success', 'User created!'],
        'dismiss_modal' => true,
        'reload_datatables' => true,
    ]);

The following key/value pairs are available.

    'dismiss_modal' => true,

Dismisses the currently open Bootstrap modal.

    'flash_now' => ['success', 'User created!'],
    
Flashes an alert immediately. The first array element is the bootstrap class name, and the second is the message.

    'flash_after' => ['success', 'User created!'],
    
Flashes an alert on the next request. Useful for showing alerts after a redirect/page reload.

    `redirect` => route('login'),
    
Redirects the user to the specified URL.

    `reload_datatables` => true,
    
Reloads the datatables on the page with updated data.

    `reload_page` => true,
    
Reloads the current page the user is on.

### Custom Responses

If you wish to add your own JSON response handlers, you can do so in your `public/js/app.js` file by leveraging the `ajaxComplete` method:

    $(document).ajaxComplete(function (event, xhr, settings) {
        if (xhr.hasOwnProperty('responseJSON') && xhr.responseJSON.hasOwnProperty('do_my_function')) {
            console.log(xhr.responseJSON.do_my_function);
        }
    });
    
In the above example, the key for your JSON response would be `do_my_function`.