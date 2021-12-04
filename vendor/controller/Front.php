<?

namespace controller;

use claire\ForWhat;
use claire\FromWhere;
use claire\Transfer;

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

    public static function addForWhat($name): int
    {
        return ForWhat::add($name);
    }

    public static function addFromWhere($name): int
    {
        return FromWhere::add($name);
    }

    public static function addTransfer($amount, $for_id, $from_id, $desc, $date)
    {
        return Transfer::addTransfer($amount, $for_id, $from_id, $desc, $date);
    }
}
