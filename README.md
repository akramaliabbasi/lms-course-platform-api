# LMS-Course-Platform

- [About](#about)
- [License](#license)

### About
LMS-Course-Platformis a Learning Management System (or LMS) that facilitates the creation of educational content by allowing you to manage courses and learning modules. The platform is simple and intuitive and provides features for:
1. The Admin 
2. The Teacher (course creator)
3. The Student (or user)

As the name suggests, LMS-Course-Platform's built on the latest Laravel framework, and uses various open source packages.
This application is still in development, if you want to collaborate on the development, send us an email: 
```
Akram Abbasi: mohdakramabbasi@gmail.com
```

### Installation
* Run `git clone https://github.com/lms-course-platform-api/lms-course-platform-api.git`
* `cd lms-course-platform-api` 
* Run `composer install` (install composer beforehand)
* From the projects root run `cp .env.example .env`
* Configure your `.env` file, with:
* Run `php artisan config:clear`

Database settings
```
DB_DATABASE=digital_course_platform
DB_USERNAME=root
DB_PASSWORD=root
```
Google recaptcha settings (which you can configure from https://www.google.com/recaptcha/admin/site)
```
ENABLE_CAPTCHA=true
NOCAPTCHA_SITEKEY=xxxxxxxxxx
NOCAPTCHA_SECRET=xxxxxxxxxxx
```

Email settings (using a provider like Mailgun, Amazon SES, etc)

* Run `php artisan key:generate`
* Run `php artisan migrate `
* For Auth API (to configure Laravel Passport), run: `php artisan passport:install`
* Run `npm install && npm run dev`
* Run `php artisan db:seed` or `php artisan --seed`
* Run `php artisan optimize:clear`
* Run `php artisan config:clear` #if you updated the config file
* Run `php artisan route:clear` 

* Start the Laravel server `php artisan serve --port=8000`

* Start the Websocket server (for chat functionality) `php artisan websockets:serve`


API documentation

#http://127.0.0.1:8000/api/documentation#/default

API import in Postman find the file name 
#lms-course-platform-api.postman_collection.json



### License
LMS-Course-Platformis licensed under the MIT license. Enjoy!


