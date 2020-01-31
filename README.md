Portfolio Fabien Retailleau
========================

Requirements
------------

  * PHP 7.2.9 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements].

Installation
------------
Remember to load vendor files

```bash
$ git clone https://github.com/FabienRet/portfolio.git
```

Usage
-----

```bash
$ cd my_project/
$ symfony serve
```

If you don't have the Symfony binary installed, run `php -S localhost:8000 -t public/`
to use the built-in PHP web server or [configure a web server][3] like Nginx or
Apache to run the application.

Create a database structure with
------

```bash
$ bin/console doctrine:migrations:migrate
```

Load Fixtures for have the admin
