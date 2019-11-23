# Laravel-Vue SPA with BOM Management

> A simple minimum viable product of Bill of Materials management software using Laravel-Vue SPA framework.
> This exercise was part of requirements submitted to me for a proposed system.

<p align="center">
<img src="https://i.imgur.com/NHFTsGt.png">
</p>

![System Overview](https://raw.githubusercontent.com/asakapab0i/bom-management/master/Capture1.PNG)
![Product Overview](https://raw.githubusercontent.com/asakapab0i/bom-management/master/Capture2.PNG)

Here's the deployment link.
[Bom Management](https://bom-mgmt.herokuapp.com/bom/materials)
[Demo Account Registration](https://bom-mgmt.herokuapp.com/bom/register)

## Installation

- `composer create-project --prefer-dist cretueusebiu/laravel-vue-spa`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `php artisan key:generate` and `php artisan jwt:secret`)
- `php artisan migrate`
- `npm install`

## Usage

#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

#### Production

```bash
npm run production
```

## Changelog

Initial release
Heroku deployment
Readme.md Update
