<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Todo Web Application
This is a todo list app allow users to manage their tasks.

## API Documentation
### Create User 

```http
POST /api/auth/register
```

| Parameter             | Type     | Default | Description                                                 |
|-----------------------|----------|---------|-------------------------------------------------------------|
| `name` (required)     | `String` | `none`  | Name of the user                                            | 
| `email` (required)    | `String` | `none`  | Email address of the user                                   |
| `password` (required) | `String` | `none`  | `minimum` of 6 characters. Password for the registered user |
