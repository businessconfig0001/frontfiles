# Frontfiles
FrontFiles Project

## Setup

Make sure you have `npm` & `composer` installed

Navigate to the root directory

You can use your own `.env` file or copy the `.env.example` provided.

### Install dependencies

```
$composer install
$npm install
```

### Generate project key

```
$php artisan key:generate
```

### Migrate & seed the database (not yet implemented)

```
$php artisan migrate
$php artisan db:seed
```

### Compile SASS & Vue with Webpack

Development build
```
$npm run dev
```