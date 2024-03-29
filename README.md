# Loggable (Provides functions to record user activities in the application models.)

**Loggable** is a package for Laravel 5.7+ that adds functionalities to record user activities on the tables in the application database, inspired by the [haruncpi/laravel-user-activity](https://github.com/haruncpi/laravel-user-activity) package.

Loggable saves a record in the **logs** table each time a user performs an operation on each model that uses the **Trait** on the **created**, **updated** and **deleted** events.


## Installation

```
composer require jvizcaya/loggable
```

We publish the config file if we want to change the table name in the database used by this package, as well as other options.

```
php artisan vendor:publish --provider="Jvizcaya\Loggable\LoggableServiceProvider"
```

Run the migration to export the **logs** table in the database.

```
php artisan migrate
```

## Use mode

Add the trait `Jvizcaya\Loggable\Loggable` to the model of the table we want the user activity logs to be saved.

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Jvizcaya\Loggable\Loggable;

class Post extends Model
{
    use Loggable;

}
```

That's all, in the previous example a record will be made in the **logs** table every time a user saves, updates or deletes in the **Post** model table.

## Retrieve models logs

This package was built in using the Laravel [one-to-many polymorphic relationship](https://laravel.com/docs/8.x/eloquent-relationships#one-to-many-polymorphic-relations) convention and the trait `Jvizcaya\Loggable\Loggable` has the model relationship definition.

**Load post logs**
```php
use App\Models\Post;

$logs = Post::find(1)->logs;
```

**Lazy Eager Loading**
```php
use App\Models\Post;

$posts = Post::with('logs')->get();
```

**Scope lastLogs($limit = 10, $loadUser = true, $userColumns = 'id,name')**

Optionally we can use the scope **lastLogs** to load the model last logs. This function accepts as the first parameter the maximum number of results.

```php
Post::lastLogs(10)->get();
```
By default this function loads the user data associated with each log.
If we want to select the columns of the user table, we can pass a string with the names of the columns separated by a comma(,) as the third parameter.
```php
Post::lastLogs(10, true, 'id,name,email,status')->get();
```  
To disable the loading of user data, pass a boolean false as the second parameter.
```php
Post::lastLogs(20, false)->get();
```  

## Log model data
By default, model data will be saved to the payload object's data attribute on **delete** operations. You can disable this functionality by setting the **log_data** variable in the configuration file to **false**.

## Logs delete (console command)  

To delete the activity log data, we can use the available console command **loggable:delete**, this command will delete the logs that are older than the days defined in the loggable.php configuration file (30 days by default).

```
php artisan loggable:delete
```

Optionally, we can pass the value of the days as the command argument.

```
php artisan loggable:delete 5
```

Add the console command **loggable:delete** to [Task scheduling](https://laravel.com/docs/8.x/scheduling) for run the command automatically.  

---

## Note

This package use the model file `Jvizcaya\Loggable\Models\Log`.

## License

[MIT](LICENSE) © Jorge Vizcaya | jorgevizcayaa@gmail.com
