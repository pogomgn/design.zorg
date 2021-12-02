<?

namespace classes;

use classes\DB;

class Utils
{
    public static function get_table($name, $width = 400, $class = "")
    {
        $res = "<table style='width: {$width}px;' " . ($class == "" ? "" : " class='$class'") . ">";

        $db = new DB();
        $fields = $db->getFields($name);

        $res .= "<tr>";
        for ($i = 0; $i < count($fields); $i++) {
            $res .= "<td><b>{$fields[$i]->name}</b></td>";
        }
        $res .= "</tr>";

        $rows = $db->selectAll($name);
        foreach ($rows as $row) {
            $res .= "<tr>";
            for ($i = 0; $i < count($fields); $i++) {
                $res .= "<td>{$row[$fields[$i]->name]}</td>";
            }
            $res .= "</tr>";
        }

        $res .= "</table>";
        return $res;
    }

    public static function get_res($res_handle, $width = 400, $class = "")
    {
        $res = "<table style='width: {$width}px;' " . ($class == "" ? "" : " class='$class'") . ">";

        $fields = $res_handle->fetch_fields();

        $res .= "<tr>";
        for ($i = 0; $i < count($fields); $i++) {
            $res .= "<td><b>{$fields[$i]->name}</b></td>";
        }
        $res .= "</tr>";

        while ($row = $res_handle->fetch_assoc()) {
            $res .= "<tr>";
            for ($i = 0; $i < count($fields); $i++) {
                $res .= "<td>{$row[$fields[$i]->name]}</td>";
            }
            $res .= "</tr>";
        }

        $res .= "</table>";
        return $res;
    }

    public static function log($mess)
    {
        $handle = fopen(__DIR__ . '/log.txt', 'a');
        fwrite($handle, "\r\n" . (new \DateTime())->format('Y-m-d H:i:s ') . $mess);
        fclose($handle);
    }
}