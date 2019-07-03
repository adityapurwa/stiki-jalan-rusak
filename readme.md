# Lapor Jalan

By Aditya Purwa 171116002

## Introduction

This project is intended for final assignment of STIKIS's Web Development class.

## Setting Up

The project is tested using PHP 7.2, and using MySQL 5.7 as the database.

### Back End Setup

To setup the backend, use the `api` folder. Inside, create a storage folder if it doesn't exists.

Do the database configuration in `core/db.php`, set the appropriate database credentials. After setting up
the database, make sure to run the `migrations/0000_init.sql` to build the database.

The logic for the API is inside `v1`.

Note you need to install the required composer dependencies too.

### Front End Setup

To setup the frontend, use the `web` folder. To configure the API url, open `app/Axios.js` and set the
API url appropriately.

Make sure to do NPM install first and run `npm run build` to build
the source into `dist` folder. The main page will be hosted at `dist/index.html`.
