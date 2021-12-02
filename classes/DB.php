<?

namespace classes;

use mysqli;

class DB
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS) or die ("db error");
        $this->db->select_db(Config::DB_NAME);
        $this->db->query("set names utf8");
    }

    public function __destruct()
    {
        $this->db->close();
    }

    public function selectOne($query): array
    {
        $res = $this->db->query($query);
        if (0 == $res->num_rows) return [];
        return $res->fetch_assoc();
    }

    public function getFields($table): array
    {
        $res = $this->db->query("select * from `$table`;");
        return $res->fetch_fields();
    }

    public function selectAll($table): array
    {
        $res = $this->db->query("select * from `$table`;");
        if (0 == $res->num_rows) return [];
        $ret = [];
        while ($item = $res->fetch_assoc()) {
            $ret[] = $item;
        }
        return $ret;
    }

    public function query($request): array
    {
        $res = $this->db->query($request);
        if (0 == $res->num_rows) return [];
        $ret = [];
        while ($item = $res->fetch_assoc()) {
            $ret[] = $item;
        }
        return $ret;
    }

    public function getLastId()
    {
        return $this->db->insert_id;
    }
}