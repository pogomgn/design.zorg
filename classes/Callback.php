<?

namespace classes;

use claire\Transfer;

class Callback
{
    public const GET_TRANSFERS = 1;

    public static function getOrders(): array
    {
        $res = (new Transfer())->getOrders();
        foreach ($res as $k => $value) {
            $res[$k]['dateStart'] = substr($value['dateStart'], 0, 10);
            $res[$k]['dateEnd'] = substr($value['dateEnd'], 0, 10);
            $res[$k]['dateAdd'] = substr($value['dateAdd'], 0, 10);
        }
        return $res;
    }

}