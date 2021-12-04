<?

namespace claire;

use classes\Config;
use classes\DB;
use classes\Utils;
use DateTime;
use Exception;

abstract class Transfer
{
    protected $db;
    protected const TABLE = 'transfer';
    public $id;

    public array $fields;

    public const DATE = 'DATE';
    public const AMOUNT = 'amount';
    public const TYPE = 'type';
    public const FOR_WHAT = 'forwhat_id';
    public const FROM_WHERE = 'fromwhere_id';
    public const DESC = 'description';


    public function __construct($id = 0)
    {
        $this->db = new DB();
        $this->id = $id;
        if ($this->id) {
            $this->fields = $this->db->selectOne('select * from `' . static::TABLE . '` where `id` = ' . $id . ';');
        }
    }

    protected abstract static function getType(): int;

    public static function getTotalIncome($year = 0, $month = 0)
    {
        return (new DB())->query('select sum(`amount`) as amount from `' . static::TABLE . '` where `type` = ' . static::getType() . ';')[0];
    }

    public static function addTransfer($amount, $for_id, $from_id, $desc = '', $date = '')
    {
        $date = !$date ? 'sysdate()' : "'$date'";
        $db = new DB();
        $db->query('insert into `' . static::TABLE . "` (`date`, `amount`, `type`, `forwhat_id`, `fromwhere_id`, `description`) value ($date, $amount, " . static::getType() . ", $for_id, $from_id, '$desc')");
        return $db->getLastId();
    }
}
