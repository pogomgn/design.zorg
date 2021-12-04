<?

namespace claire;

use classes\Config;
use classes\DB;
use classes\Utils;
use DateTime;
use Exception;

class FromWhere
{
    protected const TABLE = 'from_where';

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
