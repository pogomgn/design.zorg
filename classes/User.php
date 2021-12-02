<?

namespace classes;

use classes\DB;

class User
{
    private static $login = "";
    private static $logged_in = false;

    public static $user_id = 0;

    public static function getLogin()
    {
        return self::$login;
    }

    public static function setLogin($login)
    {
        self::$login = $login;
    }

    public static function SignIn($password)
    {
        if (self::$login == "" || self::$logged_in) return false;

        $f = (new DB)->selectOne("SELECT * FROM `users` WHERE `login`='" . self::$login . "';");
        if ((self::$login == $f['login']) && (md5($password) == $f['password'])) {
            self::$logged_in = true;
            self::$user_id = $f['id'];
            return true;
        }
        self::$logged_in = false;
        return false;
    }

    public static function getRights($uid)
    {
        $f = (new DB)->selectOne("SELECT * FROM `users` WHERE `id`='" . $uid . "';");
        return $f["rig"];
    }

    public static function getType($uid)
    {
        $f = (new DB)->selectOne("SELECT * FROM `users` WHERE `id`='" . $uid . "';");
        return $f["type"];
    }

    public static function getFullName($uid)
    {
        $f = (new DB)->selectOne("SELECT * FROM `users` WHERE `id`='" . $uid . "';");
        return $f["name"];
    }
}