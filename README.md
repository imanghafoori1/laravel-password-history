# Laravel password history
Keep a password history of your users to prevent them from reusing the same password.

# Installation
```
composer require imanghafoori/laravel-password-history
```

```
php artisan vendor:publish
php artisan migrate
```

To publish the config file and migrate the database.

Visit the `config/password_history.php` file to see all the possibilities.

# Usage

This package will observe the `saved` event of the User models (which are mentioned in the config file) and records the password hashes automatically.
```php
<?php
// When inserting, it will also log the password hash in the "password_histories" table
 User::create($data);

// Sample for changing the password
$user = User::find($id);
$passHash = Hash::make(request('new_password'));

$user->password = $passHash;
$user->save(); // after saving the model, the password change  will be recorded, automatically
```
Be careful that chaing the model like below does not fire any model event hence to password change would be recorded behind the scenses.

```php
<?php
// Here we do NOT get the model from db
// and only send an update query
// so laravel does not fire model events
User::where('id', $id)->update($data);
```

And there is a validation rule for you to check the entire password history agaist the new password in laravel validation rules.

Again you may want to take a quick look at the source code to see what is going on there.

# QA

- I have a `users` table and an `admins` table (User model and Admin model), can I also track password changes for admins?
```
Yeah, the package supports it, visit the config file.
```

