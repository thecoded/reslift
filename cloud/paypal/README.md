Pizza App using PayPal REST API
===============================

Overview
--------

This is a simple pizza store app that showcases the features of PayPal's REST APIs. The application uses the SDKs provided by PayPal.  The app demonstrates how you
   
    * Save a credit card with paypal for future payments.
    * Make a payment using a saved credit card id.
    * Make a payment using paypal as the payment method.

Pre-requisites
--------------

   * PHP 5.3+
   * curl, openssl and mysql PHP extensions
   * [Composer](http://getcomposer.org/download/) for installing the Rest API SDK.
   * Mysql 5.x server 

	
Running the app
---------------

   * Copy the rest-api-sample-app-php folder to your htdocs folder.
   * Run 'composer update' from the root directory.
   * Create a new database called *paypal_pizza_app* and update connection parameters in app/bootstrap.php file.
   * Create the necessary tables as give in install/db.sql or simply run the install/create_tables.php file
   * Optionally, update *app/bootstrap.php* with your own client id and client secret.
   * You are ready. Bring up http://localhost/rest-api-sample-app-php on your favorite browser.
      * Create a test 'PizzaShop' account from the sign up page and login.
	  * Order a pizza and select a payment method from the payment review page.
	
References
----------

   * Github repository for PHP REST API SDK - https://github.com/paypal/rest-api-sdk-php

	 
