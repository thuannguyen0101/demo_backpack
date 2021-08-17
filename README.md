<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Thư viện Permission

`Thư viện cho phép quản lý role, permission bằng giao diện web, có khả năng gán role, premission linh hoạt cho từng user.`

> **Devs phải tự thêm checks cho từng role, permission vào từng khu vực của code để sử dụng, thư viện _không_ hỗ trợ việc này.**

#### Cài đặt thư viện

```bash
composer require backpack/permissionmanager

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider"
```

#### Khai báo trait cho model User

```php
class User extends Authenticatable
{
    // trait này dùng dể thêm role, permission vào model
    use \Spatie\Permission\Traits\HasRoles;
    // trait này dùng để quản lý (CRUD) model User, gán role, premission...
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
}
```

#### Thêm link vào sidebar

Trong file [**resources/views/vendor/backpack/base/inc/sidebar_content.blade.php**](resources/views/vendor/backpack/base/inc/sidebar_content.blade.php)

```html
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"
        ><i class="nav-icon fa fa-group"></i> Authentication</a
    >
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('user') }}"
                ><i class="nav-icon fa fa-user"></i> <span>Users</span></a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('role') }}"
                ><i class="nav-icon fa fa-group"></i> <span>Roles</span></a
            >
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('permission') }}"
                ><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a
            >
        </li>
    </ul>
</li>
```

#### Quản lý Permission, Role bằng giao diện admin

-   Thêm permission [admin/permission]()
-   Thêm role, gán permission vào role [admin/role]()
-   Gán user vào role [admin/user]()

#### Giới hạn user role vào backend

Trong [**App\Models\User.php**](app/Models/User.php) sửa hàm isAdmin

```php
public function isAdmin()
{
    if ($this->id === 1) {
        // if user id = 1 = super admin, auto grant admin permission, this prevent user can not login to backend because no role is created yet.
        return true;
    }
    return $this->hasRole("Admin"); // using role name
}
```

#### Sử dụng permission check

-   [https://github.com/Laravel-Backpack/PermissionManager#api-usage](https://github.com/Laravel-Backpack/PermissionManager#api-usage)
-   [https://github.com/spatie/laravel-permission](https://github.com/spatie/laravel-permission)

**Ví dụ:**

Trong code

```php
if (backpack_user()->can(" premission name")) {
    // do stuff
}
```

Trong file blade

```html
@if(backpack_user()->hasRole("role name"))
<!-- show stuff -->
@endif
```

#### Hoàn thiện sản phẩm, đẩy lên production.

Vào file [config/backpack/permissionmanager.php](config/backpack/permissionmanager.php)

Sửa lại rules

```php
    'allow_permission_create' => false,
    'allow_permission_update' => false,
    'allow_permission_delete' => false,
    'allow_role_create'       => false,
    'allow_role_update'       => false,
    'allow_role_delete'       => false,
```

để ngăn admin thay đổi nội dung permission và role.

> Admin vẫn có quyền gán permission, role cho user.
