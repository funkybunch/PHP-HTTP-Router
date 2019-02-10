# Simple HTTP Router

A simple router for HTTP requests written in PHP.  Simple HTTP Router allows you to have a single point of entry for your web application or API and explicitly call different functions based on the HTTP `REQUEST_METHOD` and `REQUEST_URI`.

## Installation
#### Simplest (Composer)
The quickest way to get up and running is to use [Composer](https://github.com/composer/composer).

1. Once you have Composer installed, initialize it in your root project directory using:
    ```sh 
    $ composer init
    ```
2. Now you're all ready to start adding some dependencies.  To install Simple HTTP Router:
    ```sh
    $ composer require funkybunch/simple-http-router
    ```

That's it!  Just make sure to `autoload` at the top of your code.
```php
<?php
require 'vendor/autoload.php';
```

#### Complex (Manual)
Download the files in the repo and navigate to the `src/` directory.  These are the files you will need to `include` or `require` to get going.
```sh
src/
 |- HTTPErrors.php
 |- Request.php
 |- Router.php
```

You will need to include all 3 since they use a `namespace` and do not reference each other directly.

Keep in mind that composer will **not** be able to automatically update this dependency if you do a manual installation so it is highly recommended that you use Composer instead.


## Usage
Once you are all setup and have everything installed, create the file you want to use as your web app/api facing file.  Typically, this will be an `index.php` file in your web server live directory root.  We'll refer to this as your `router` file.

#### Create the `Router()`
To get started, you need to create a new `Router()` object:
```php
$router = new FunkyBunch\SimpleHTTPRouter\Router;
```

#### `GET` Request
To setup a route for a `GET` request, use the `get()` method in the `Router()` class.  This method requires the `$path` that you are setting the route for, as well as an anonymous `function()`.  This `function()` is called if the `$path` matches the HTTP request.

You can add as many `get()` methods as you need.
```php
$router->get($path, function(){});
```

##### Here's what your `index.php` file might look like at this point:
```php
<?php
/**
 * HTTP Router for myWebApp
 * @author You!
 */

$router = new FunkyBunch\SimpleHTTPRouter\Router;

$router->get('/', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>Hello world</h1>";
});

$router->get('/about', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>About Us</h1>";
});
```

#### `POST` Request
To setup a route for a `POST` request, use the `post()` method in the `Router()` class.  Similarly to the `get()` method, this method requires the `$path` that you are setting the route for, as well as an anonymous `function()`.  This `function()` is called if the `$path` matches the HTTP request.
```php
$router->post($path, function(){});
```
##### Here's what your `index.php` file might look like at this point:
```php
<?php
/**
 * HTTP Router for myWebApp
 * @author You!
 */

$router = new FunkyBunch\SimpleHTTPRouter\Router;

$router->get('/', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>Hello world</h1>";
});

$router->get('/about', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>About Us</h1>";
});

$router->post('/api/contact', function() {
    // The following code will be executed when this `route` is called.
    // Handle `POST` data
});
```

#### `getRequest()` Method
If you are building an API, you will likely need to get the `body` of the HTTP request.  This can be done using the `getRequest()` method.  This returns the request object for both `GET` and `POST` requests.
```php
$router->getRequest()
```

It is possible to use this method inside the `callback` function for either the `get()` or `post()` methods using a [closure](http://php.net/closure).  For example:
```php
$router->post($path, function() use(&$router) {
    $request = $router->getRequest();
    // DO SOMETHING WITH $request
}
```
The `&` is important because it tells PHP to use the global variable that you have already defined.

##### Here's what your `index.php` file might look like at this point:
```php
<?php
/**
 * HTTP Router for myWebApp
 * @author You!
 */

$router = new FunkyBunch\SimpleHTTPRouter\Router;

$router->get('/', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>Hello world</h1>";
});

$router->get('/about', function() {
    // The following code will be executed when this `route` is called.
    echo "<h1>About Us</h1>";
});

$router->post('/api/contact', function() use(&$router) {
    // The following code will be executed when this `route` is called.
    $request = $router->getRequest();
    
    // DO SOMETHING WITH $request to read POST data
});
```

**Note:** Even if Apache, or your favorite web server, is serving `/var/www/mywebapp/web/` then it can still reference files in `/var/www/mywebapp/`.  This way you can keep the rest of your application files out of a live web directory.  The important part is that the file using the router is in the live directory.

## Contributing & Bugs
Contributions are always welcome!  Draft a [pull request](https://github.com/funkybunch/Simple-HTTP-Router/pulls) with any changes or improvements you make and submit it for review.

For bug reports, please create an [issue](https://github.com/funkybunch/Simple-HTTP-Router/issues) and I will look into it further.

## Roadmap
- Advanced Error States & Handling


##License
Copyright (c) 2019 Mark Adkins and other [contributors](https://github.com/funkybunch/Simple-HTTP-Router/graphs/contributors).  This project is Open Source and licensed under the [MIT License](https://github.com/funkybunch/Simple-HTTP-Router/blob/master/LICENSE).