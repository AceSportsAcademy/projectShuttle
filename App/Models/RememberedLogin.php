<?php

namespace App\Models;

use \App\Token;
use PDO;

/**
 * Remembered login table model
 *
 * PHP version 7.0
 */
class RememberedLogin extends \Core\Model
{
	/***
   * Find a remembered login model by the Token
   * @param string $token Remembered token
   * @return mixed Remembered login object if found, false otherwise
   */
  public static function findByToken($token)
  {
  		$token = new Token($token);
  		$token_hash = $token->getHash();

  		$sql = 'SELECT * from remembered_logins WHERE token_hash = :token_hash';
    	$db = static::getDB();
    	$stmt = $db->prepare($sql);

    	$stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);

    	$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    	$stmt->execute();

    	return $stmt->fetch();
  }

  /**
     * Get the user model associated with this remembered login
     *
     * @return User The user model
     */

    public function getUser()
    {
  		
  		return User::findByID($this->user_id);  	
        
    }

    /**
     * See if the remembered token has expired or not, based on the current system time
     *
     * @return boolean True if the token has expired, false otherwise
     */

    public function hasExpired()
    {
  		
  		return strtotime($this->expires_at) < time();  	
        
    }

    /**
     * Delete this model
     *
     * @return Void
     */

    public function delete()
    {
  		
  		$sql = 'DELETE FROM remembered_logins WHERE token_hash = :token_hash';

  		$db = static::getDB();
    	$stmt = $db->prepare($sql);

    	$stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);
    	$stmt->execute();
        
    }
}