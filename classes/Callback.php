<?

namespace classes;

use controller\Front;

class Callback
{
    public const GET_SELECTS = 1;
    public const ADD_FROM = 2;
    public const ADD_FOR = 3;

    public static function getSelects(): array
    {
        return Front::getSelects();
    }

    public static function addForWhat(): array
    {
        return Front::getSelects();
    }

    public static function addFromWhere(): array
    {
        return Front::getSelects();
    }
}