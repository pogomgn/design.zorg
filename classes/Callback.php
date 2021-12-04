<?

namespace classes;

use claire\Income;
use claire\Outcome;
use controller\Front;

class Callback
{
    public const GET_SELECTS = 1;
    public const ADD_FROM = 2;
    public const ADD_FOR = 3;
    public const ADD_INCOME = 4;
    public const ADD_OUTCOME = 5;

    public static function getSelects(): array
    {
        $data = Front::getSelects();
        $for = '
            <label for="description">За что</label>
            <select class="custom-select" id="forWhat">
                <option value="0" selected>Не выбрано</option>';
        foreach ($data['for'] as $v) {
            $for .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
        }
        $for .= '
            </select>
        ';
        $from = '
            <label for="description">От кого</label>
            <select class="custom-select" id="fromWhere">
                <option value="0" selected>Не выбрано</option>';
        foreach ($data['from'] as $v) {
            $from .= '<option value="' . $v['id'] . '">' . $v['name'] . '</option>';
        }
        $from .= '
            </select>
        ';

        return [
            'for' => $for,
            'from' => $from,
        ];
    }

    public static function addForWhat($data): int
    {
        return Front::addForWhat($data['name']);
    }

    public static function addFromWhere($data): int
    {
        return Front::addFromWhere($data['name']);
    }

    public static function addTransfer($data, $income): int
    {
        if ($income) {
            return Income::addTransfer($data['amount'], $data['for'], $data['from'], $data['desc'], $data['date']);
        }
        return Outcome::addTransfer($data['amount'], $data['for'], $data['from'], $data['desc'], $data['date']);
    }
}