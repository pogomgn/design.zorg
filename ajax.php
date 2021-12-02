<?

use classes\User;
use classes\Callback;
use classes\Utils;
use classes\DB;

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_set_cookie_params(30800);
session_start();

function getTest($type, $data = '')
{
    if (1 == $type) {
        return substr('abcdef', 0, -2);//Utils::get_table('orderplan', '1000');
    } elseif (2 == $type) {
        $db = new DB();
    } elseif (3 == $type) {

    } elseif (4 == $type) {
        return print_r((new DB())->query('select `name` as haha from `order`;'), true);
    } elseif (5 == $type) {
        return Utils::get_table('orderostatok', '1000');
    } elseif (6 == $type) {

    }
}

if (!$_SESSION["enter"]) {
    die;
}

$uid = $_SESSION["us_id"];
$USER = [
    'name' => User::getFullname($uid),
    'type' => User::getType($uid),
    'rig' => User::getRights($uid),
    'id' => $_SESSION["us_id"],
];
$isAdmin = $USER['type'] == 1;
ob_end_flush();

$type = addslashes($_REQUEST['type']);
$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : [];

switch ($type) {
    case Callback::GET_TRANSFERS:
        echo json_encode(['data' => Callback::getOrders()]);
        break;
    default:
        echo 'error 0';
        break;
}