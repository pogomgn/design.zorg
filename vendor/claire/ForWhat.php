<?

namespace claire;

use classes\Config;
use classes\DB;
use classes\Utils;
use DateTime;
use Exception;

class ForWhat
{
    protected const TABLE = 'for_what';

    public static function getList(): array
    {
        return (new DB)->selectAll(self::TABLE);
    }

    public static function add($name): int
    {
        $db = new DB;
        $db->query('insert into `' . self::TABLE . '` (`name`) value (\'' . $name . '\');');
        return $db->getLastId();
    }
}
