<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mvcdb';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'mvcadmin';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'password';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var string
     */
    const SECRET_KEY = '9IhO4R7Y2iG02cubNR0qrduc3QEHXQ63';

    /**
     * Mailgun domain
     * @var string
     */
    const MAILGUN_DOMAIN = 'sandboxd647dc6d6ac1402b962a0a485f3b6c2c.mailgun.org';


    /**
     * Mailgun domain
     * @var string
     */
    const MAILGUN_API_KEY = 'key-3134955d1767582d1cb651989eec504b';

}
