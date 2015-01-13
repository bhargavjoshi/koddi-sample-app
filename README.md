Koddi
========

Sample app for koddi.com, It uses Silex 


Getting Started
===============

#### Clone koddi-sample-app

```bash
$ git clone https://github.com/bhargavjoshi/koddi-sample-app.git
$ cd koddi-sample-app
```

Open `config/propel/buildtime-conf.xml` and fillout with proper database username, password and database name.


Repeat the same with `config/propel/runtime-conf.xml`


#### Use composer to install dependencies

```bash
$ composer install
```

#### Generate config file

```bash
$ vendor/bin/propel config:convert-xml --output-dir="config/propel" --input-dir="config/propel"
```

#### Generating Required propel classes

```bash
$ ./propel build
```

#### Migrating the Database

```bash
$ ./propel migrate
```
