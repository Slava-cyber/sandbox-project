# The 'Sandbox' app - is the place for meeting people with the same interests.

<hr style="background-color: #54b686; height: 3px">

## Description

This is an educational project with ambition to be improved.
It is intended as framework-less application — no major frameworks/libraries are used, other than Bootstrap for visual features. All backend is custom, its structure is inspired by Laravel.

App uses MVC pattern for separation of concerns:

**Model**, which includes custom QueryObject-style interface for interaction with MySQL database via PDO and Entity classes for corresponding MySQL tables, can be found in [**~/src/Models**](https://github.com/Slava-cyber/sandbox-project/tree/master/src/Models).

**View**, which includes View-classes that format data for usage in templates [**~/src/View**](https://github.com/Slava-cyber/sandbox-project/tree/master/src/View)

**templates** can be found in [**~/templates**](https://github.com/Slava-cyber/sandbox-project/tree/master/templates).

**Controller**, which includes all the data fetching, API handling, validation etc., can be found in [**~/src/Controllers**](https://github.com/Slava-cyber/sandbox-project/tree/master/src/Controllers).

**Routing**, which is usually considered to be part of Controller too, is located in [**~/src/System**](https://github.com/Slava-cyber/sandbox-project/tree/master/src/System).

**routes** is located in [**~/routes**](https://github.com/Slava-cyber/sandbox-project/tree/master/routes)

This app exploits server-side rendering with a few JavaScript-enabled interactivity features.

Commits have preceding task codes (e.g. T2 -  4) for internal use, can be ignored.

Used PHP version: 7.4. The code is written in compliance with PSR-12. Virtual machine or container with LAMP is recommended.

## How to run
To have a fully-functional application, after cloning this repo you have to:
Using example settings files which are located in [**~/settings**](https://github.com/Slava-cyber/sandbox-project/tree/master/settings), rewrite them with your data.

db.example.php:

1. name of host (e.g. 'localhost')
2. name of database (in MySQL)
3. name of MySQL user (e.g. 'webapp')
4. password for this user

email.example.php:

1. name of host (e.g. 'ssl://smtp.gmail.com')
2. username for SMTP client
3. password for this user (search for App Password in your email client)
4. email that will be displayed in email (should be the same as SMTP username probably)

## Admin app for this website

There is a separate admin app written in React + TypeScript. It's stored in a separate repo [sandbox-admin](https://github.com/Slava-cyber/sandbox-admin-react-project).

## Contacts

Should you have any suggestions, please text me in Telegram via [@muravlevslava](https://t.me/muravlevslava)!