## About Bossview-Filament

Requirment
---
Filament requires the following to run:
* PHP 8.1+
* Laravel v10.0+
* Livewire v3.0+

Install
---
[Filament v3 install docs](https://filamentphp.com/docs/3.x/panels/installation)
```php=
// pull from gitlab
git clone https://it-gitlab.tp.elearn.com.tw/ovobannyovo/bossview-filament.git

// run migrate & create user
php artisan migrate
php artisan make:filament-user

// open 127.0.0.1:8000/admin and login
php artisan serve
```