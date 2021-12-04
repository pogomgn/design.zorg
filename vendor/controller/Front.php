<?

namespace Controller;

use claire\ForWhat;
use claire\FromWhere;

class Front
{
    public static function getSelects(): array
    {
        $from = FromWhere::getList();
        $for = ForWhat::getList();
        return [
            'from' => $from,
            'for' => $for,
        ];
    }

    public static function addForWhat($name)
    {
        return ForWhat::add($name);
    }

    public static function addFromWhere($name)
    {
        return FromWhere::add($name);
    }
}
