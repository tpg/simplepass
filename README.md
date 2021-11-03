# SimplePass for Laravel

A simple site-wide lockout (kinda like Basic HTTP auth).

Install using Composer:

```
composer require thepublicgood/simplepass
```

Set a new password with:

```
php ./artisan simplepass:set MY_PASSWORD
```

This will set a `SIMPLE_SECRET` value in `.env`.

When attempting to browse your site, you'll get redirected to `/simplepass/auth` and a password request. Use the password you set to unlock. If you ever need to log out, simply visit `/simplepass/logout`.

## Configuration

You can publish the configuration file with:

```
php ./artisan vendor:publish --provider=TPG\\Simple\\ServiceProvider
```

That will place a `simplepass.php` file in the config directory. Configuration options have been documented in the configuration file.
