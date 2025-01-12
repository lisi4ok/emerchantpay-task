<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>

# Emerchantpay Task

### Application Technologies:
+ Laravel
+ Vite
+ JavaScript
+ React
+ Inertia JS
+ Tailwind Css
+ etc..


## Choose a Database and copy `ENV` file

- `sqlite`
- `mysql`
- `postgres`


- `sqlite` - Copy the `.env.example` to `.env` file

`OR`

- `mysql` - Copy the `.env.example.mysql` to `.env` file

`OR`

- `postgres` - Copy the `.env.example.postgres` to `.env` file


## Install

```
{bun/deno/npm} install
```

```
composer install
```

```
php artisn key:generate
```

```
php artisan storage:link
```

```
php artisan migrate
```

```
php artisan db:seed
```

## Start
No SQLite Database:
```
docker compose -f ./docker-compose-{mysql|postgres}.yml up -d
```

```
{bun/deno/npm} run dev
```

```
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
