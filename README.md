# Diligent Notes
## _Easily create your Cornell Notes._

[![N|Diligent Notes](https://diligentnotes.com/assets/logo/diligentnotes.png)](https://diligentnotes.com/)

## Server Requirements

- PHP >= 8.0
- MySQL
- Composer
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Git

## Tech

Diligent Notes uses a number of open source projects to work properly:

- [Laravel] - PHP Framework
- [Statamic] - Laravel CMS
- [Vue.js] - JS Framework used in app pages
- [Tailwind CSS] - CSS Framework
- [CKEdditor] - WYSIWYG editor on which Cornell Notes implemented.
- [Alpine.js] - Lightweight JS framework used in marketing pages
- [jQuery] - JS Library
- [node.js] - Used to install npm packages
- [Webpack] - Module Bundler

## Installation

Go to server's public directory.

```sh
git clone https://git.brightness-group.com/cornell-notes/website.git .
composer install
cp .env.example .env
```

Create a database and set configuration in `.env` file
```sh
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Run the database migration and seeder to create tables and create essential entries.
```sh
php artisan migrate --seed
```

Change following variables in `.env` as per your setup.
```sh
APP_ENV=
APP_DEBUG=
APP_URL=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
SANCTUM_STATEFUL_DOMAINS=
STRIPE_KEY=
STRIPE_SECRET=
```

Give write permission to folders.
```sh
chmod -R ./bootstrap/cache ./storage
```

## Development

Want to develop further? Great!
Diligent Notes uses Webpack for fast developing.
Open your favorite Terminal and run these commands.

First Tab:

```sh
php artisan serve
```

Second Tab:
```sh
npm i
npm run watch
```

Navigate in your preferred browser.
```sh
127.0.0.1:8000
```

#### Building for source

For production release:

```sh
npm run prod
```
[Laravel]: <https://laravel.com/>
[Statamic]: <https://statamic.com/>
[Vue.js]: <https://vuejs.org/>
[Tailwind CSS]: <https://tailwindcss.com/>
[CKEdditor]: <https://ckeditor.com/ckeditor-5/>
[Alpine.js]: <https://ckeditor.com/ckeditor-5/>
[jQuery]: <http://jquery.com>
[node.js]: <http://nodejs.org>
[Webpack]: <https://webpack.js.org/>
