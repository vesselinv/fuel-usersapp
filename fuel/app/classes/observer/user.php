<?php
# fuel/app/classes/observer/user.php
namespace Orm;
class Observer_User extends Observer
{
  # Hook into the before_insert event,
  # Set user's IP and hash their password
  public function before_insert(Model $user)
  {
    # Hash the password
    # WARNING!!!
    # MD5 is used here only for the sake of the example.
    # You should use bcrypt for production apps or 
    # password hashing libs such as https://github.com/ircmaxell/PHP-PasswordLib
    $user->password = md5($user->password);
    
    # Running locally $_SERVER['REMOTE_ADDR'] is undefined
    $_SERVER['REMOTE_ADDR'] = '195.24.56.98';
    
    $user->last_ip = $_SERVER['REMOTE_ADDR'];
  }

  # Update user's IP when their record is being updated
  # ... assuming they're the only one's that can modify it!
  public function before_update(Model $user)
  {
    $user->last_ip = $_SERVER['REMOTE_ADDR'];
  }
}