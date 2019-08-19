## Menus para OlCms

### Instalar o MenuCms

```console
$ composer require orlandolibardi/menucms
```
```console
$ php artisan vendor:publish --provider="OrlandoLibardi\MenuCms\app\Providers\OlCmsMenuServiceProvider" --tag="config"
```
```console
$ php artisan migrate
```
```console
$ composer dump-autoload
```
```console
$ php artisan db:seed --class="MenuAdminTableSeeder"
```

# \o/



