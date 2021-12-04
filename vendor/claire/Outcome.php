<?

namespace claire;

use classes\Config;
use classes\DB;
use classes\Utils;
use DateTime;
use Exception;

class Outcome extends Transfer
{
    protected const MULTIPLIER = -1;

    protected static function getType(): int
    {
        return self::MULTIPLIER;
    }
}
