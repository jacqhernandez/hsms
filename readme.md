## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

-----------------------

Command for automatically updating the status of sales invoices that are overdue (php artisan overdue:update)

To make this work,

1. I created a batch file scheduler.bat with the following contents:
	cd C:\xampp\htdocs\hsms
	php artisan overdue:update
2. Launch the task scheduler Windows Key + R then paste in Taskschd.msc and hit enter.
3. Click Create Basic Task on the right in the Actions pane.
4. Name the task "HSMS" then click Next.
5. Leave page set to Daily and click Next.
6. Leave page as defaults and click Next.
7. Make sure Start a Program is selected and click Next.
8. Browse to the batch file created and then click Next then click Finish.
9. Select Task Scheduler Library on the left, and find task in the middle pane and right-click and click Properties
10. Go to the Triggers tab, click Daily in the list and click Edit. 
11. In the Start field, change time to 9:00:00 AM (this updates the status at 9 am). Change this if desired.
13. Click OK. Done.

-----------------------

Command for automatic db backup (php artisan backup:run --only-db)

To make this work,

1. I created a batch file scheduler.bat with the following contents:
	cd C:\xampp\htdocs\hsms
	php artisan backup:run --only-db
2. Launch the task scheduler Windows Key + R then paste in Taskschd.msc and hit enter.
3. Click Create Basic Task on the right in the Actions pane.
4. Name the task "HSMS Backup" then click Next.
5. Leave page set to Daily and click Next.
6. Leave page as defaults and click Next.
7. Make sure Start a Program is selected and click Next.
8. Browse to the batch file created and then click Next then click Finish.
9. Select Task Scheduler Library on the left, and find task in the middle pane and right-click and click Properties
10. Go to the Triggers tab, click Daily in the list and click Edit. 
11. In the Start field, change time to 9:00:00 AM (this backs up db at 9 am). Change this if desired.
13. Click OK. Done.

-----------------------

Activity log

By default records older than 2 months will be deleted. The number of months can be modified in the config-file of the package.

------------------------

for emailing soa, configure .env file 

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=dummyboi24@gmail.com
MAIL_PASSWORD=onyxsolutions
MAIL_ENCRYPTION=ssl

--------------------------

backup saved in hsms>storage>app>backups