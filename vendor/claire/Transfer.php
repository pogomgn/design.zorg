<?

namespace claire;

use classes\Config;
use classes\DB;
use classes\Utils;
use DateTime;
use Exception;

class Transfer
{
    protected $db;
    public $id;

    public function __construct($id = 0)
    {
        $this->db = new DB();
        $this->id = $id;
        if ($this->id) {
            $this->fields = $this->db->selectOne('select * from `statday` where `id` = ' . $id . ';');
        }
    }

}
