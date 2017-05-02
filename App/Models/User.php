<?php

namespace App\Models;

use \App\Token;
use \App\Mail;
use \Core\View;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

  /**
   * Error messages
   *
   * @var array
   */
  public $errors = [];

  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data = [])
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    };
  }

  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {

    $this->validate();

    if(empty($this->errors)){

    $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

    $token = new Token();
    $hashed_token = $token->getHash();
    $this->activation_token = $token->getValue();

    $sql = 'INSERT INTO users (name, email, phone, password_hash, activation_hash)
            VALUES (:name, :email, :phone, :password_hash, :activation_hash)';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
    $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

    return $stmt->execute();

    }

    return false;
  }

  /***
   * Validate current property values, adding validation errors to error array property
   *
   * @return void
   */
  public function validate()
  {
    // Name
        if ($this->name == '') {
            $this->errors[] = 'Name is required';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }

        if (static::emailExists($this->email, $this->id ?? null )){
            $this->errors[] = 'Email already exists';
        }

        // Phone number
        if ($this->phone == '') {
            $this->errors[] = 'Mobile number is mandatory';
        }

        if (strlen($this->phone) < 10) {
            $this->errors[] = 'Please enter a valid 10 digit mobile number';
        }

        if  (static::phoneExists($this->phone, $this->id ?? null)) {
            $this->errors[] = 'Phone already exists';
        }

        // Password
        if (isset($this->password)) {

            if (strlen($this->password) < 6) {
                $this->errors[] = 'Please enter at least 6 characters for the password';
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one letter';
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
                $this->errors[] = 'Password needs at least one number';
            }
        }
  }

  /***
   * Check for an existing email or phone in the table
   * @param string $email email string to search for
   * @return boolean True if a record already exist with the specified email, false otherwise
   */
  public static function emailExists($email, $ignore_id = null)
  {
      $user = static::findByEmail($email);

      if($user){
          if($user->id != $ignore_id) {
              return true;
          }
      }

      return false;
  }

  /***
   * Find a user model by email address
   * @param string $email email string to search for
   * @return User object if found, false otherwise
   */
  public static function findByEmail($email)
  {
    $sql = 'SELECT * from users WHERE email = :email';
    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    $stmt->execute();

    return $stmt->fetch();
  }

  /***
   * Check for an existing phone number in the table
   * @param string $phone phone number to search for
   * @return boolean True if a record already exist with the specified phone number, false otherwise
   */
  public static function phoneExists($phone, $ignore_id = null)
  {
      $user = static::findByPhone($phone);

      if($user){
          if($user->id != $ignore_id) {
              return true;
          }
      }

      return false;
  }

  /***
   * Find a user model by phone number
   * @param string $phone phone string to search for
   * @return User object if found, false otherwise
   */
  public static function findByPhone($phone)
  {
    $sql = 'SELECT * from users WHERE phone = :phone';
    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    $stmt->execute();

    return $stmt->fetch();
  }


  /***
   * Authenticate a user by email and password
   * @param string $email email address
   * @param string $password password
   * @return mixed the user object or false if authentication fails
   */
  public static function authenticate($email, $password)
  {
      $user = static::findByEmail($email);

      if($user && $user->is_active) {

          if(password_verify($password, $user->password_hash)){
              return $user;
          } 

      }

      return false;
  }

  /***
   * Find a user model by id
   * @param string $id id to search for
   * @return User object if found, false otherwise
   */
  public static function findByID($id)
  {
    $sql = 'SELECT * from users WHERE id = :id';
    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    $stmt->execute();

    return $stmt->fetch();
  }

  /***
   * Remember the login by inserting a new unique token to remembered_logins table for
   * the current user
   * @return boolean True if login was remembered successfully, false otherwise
   */
  public function rememberLogin()
  {
      $token = new Token();
      $hashed_token = $token->getHash();
      $this->remember_token = $token->getValue();

      $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from today

      $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
            VALUES (:token_hash, :user_id, :expires_at)';

      $db = static::getDB();
      $stmt = $db->prepare($sql);


      $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
      $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
      $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

      return $stmt->execute();

  }

  /***
   * Send password reset instructions to the user specifiec
   * @param string $email email address
   * @return void
   */
  public static function sendPasswordReset($email)
  {
      $user = static::findByEmail($email);

      if($user){

          //Start password reset process
          if($user->startPasswordReset()) {

              //send email here
              $user->sendPasswordResetEmail();
          }

      }
  }

  /***
   * Start the password reset process by generating a new token and expiry
   * 
   * @return void
   */
  protected function startPasswordReset()
  {
      $token = new Token();
      $hashed_token = $token->getHash();
      $this->password_reset_token = $token->getValue();

      $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

      $sql = 'UPDATE users
              SET password_reset_hash = :token_hash,
                  password_reset_expiry = :expires_at
              WHERE id = :id';

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
      $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
      $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

      return $stmt->execute();
  }

  /***
   * Send password reset instructions in an email to the user
   * 
   * @return void
   */
  protected function sendPasswordResetEmail()
  {

      $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/'. $this->password_reset_token;

      $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
      $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);

      Mail::send($this->email, 'Password reset', $text, $html); 

  }

  /***
   * Find a user model by password reset token and expiry
   * 
   * @param string $token Password reset token sent to the user
   * 
   * @return mixed User object if found and the token hasn't expired, null otherwise
   */
  public static function findByPasswordReset($token)
  {

      $token = new Token($token);
      $hashed_token = $token->getHash();

      $sql = 'SELECT * from users WHERE password_reset_hash = :token_hash';

      $db = static::getDB();
      $stmt = $db->prepare($sql);

      $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
      
      $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

      $stmt->execute();

      $user = $stmt->fetch();

      if($user){
          if(strtotime($user->password_reset_expiry) > time()){
              return $user;
          }
      }

  }

  /***
   * Reset the password
   * 
   * @param string $password The new Password 
   * 
   * @return boolean  True if password was updated successfully, false otherwise
   */
  public function resetPassword($password)
  { 
      $this->password = $password;

      $this->validate();

      if(empty($this->errors)){
          $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

          $sql = 'UPDATE users
                  SET password_hash = :password_hash,
                      password_reset_hash = NULL,
                      password_reset_expiry = NULL
                  WHERE id = :id';

          $db = static::getDB();
          $stmt = $db->prepare($sql);

          $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

          $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
          
          return $stmt->execute();

      }

      return false;

  }

  /***
   * Send an email to the user containing activation link
   * 
   * @return void
   */
  public function sendActivationEmail()
  {
      $url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/'. $this->activation_token;

      $text = View::getTemplate('Signup/activation_email.txt', ['url' => $url]);
      $html = View::getTemplate('Signup/activation_email.html', ['url' => $url]);

      Mail::send($this->email, 'Account activation', $text, $html); 

  }

  /***
   * Find a user model by activation token and set the is_active field to true
   * 
   * @param string $token Activation token from the URL
   * 
   * @return void
   */

  public static function activate($value)
  {

      $token = new Token($value);
      $hashed_token = $token->getHash();
      $activation_token = $token->getValue();

      $sql = 'UPDATE users
              SET is_active = 1,
                  activation_hash = NULL
              WHERE activation_hash = :hashed_token';

      $db = static::getDB();
      $stmt = $db->prepare($sql);

          $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

          $stmt->execute();

  }


}
