## Installation Guide
1 laravel new project-app
2 composer require laravel/passport --with-all-dependencies  // สำหรับ laravel version > 9.* 
    @file app/models/User 
        #แก้ไข use Laravel\Passport\HasApiTokens
    @file config/auth
        #เพิ่ม "guards" [ 
            'api' => [
                'driver' => 'passport',
                'provider' => 'users'
            ]
        ]

3 php artisan migrate
4 php artisan passport:install
5 php artisan make:controller backoffice/AuthBackOfficeController
6 php artisan make:controller backoffice/BaseController

** 7 php artisan passport:client --personal 
  // รันคำสั่งใหม่ทุกครั้งที่เคลียร์ DB
  // ถ้าไม่สร้างไว้จะ error เวลา $user->createToken('AuthToken')->accessToken; 


/*  COMMAND Lists
 
php artisan serve --host ipaddress 
php artisan migrate
php artisan make:controller NameController
php artisan make:model NameModel -mcr   
php artisan route:clear   
php artisan cache:clear   
php artisan optimize

*/

php artisan make:controller backoffice/

## Plugins

1 TailwindCSS
2 ViteJS
3 Livewire Laravel

## run dev
- npm run dev

## configure
- 'timezone' => 'Asia/Bangkok'
