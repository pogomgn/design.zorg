<?

use classes\Utils;
use League\Csv\Reader;
use ond\Order;
use ond\Statday;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if (!isset($_REQUEST['auth'])) {
    die;
}
if ('fi34so9vhsofjs34ofh3s4o8ghp8g' != $_REQUEST['auth']) {
    die;
}
$file = addslashes($_REQUEST['file']);
$reader = Reader::createFromPath($file, 'r');
try {
    $reader->setDelimiter(';');
} catch (Exception $e) {
    Utils::log(print_r($e, true));
}
try {
    $records = $reader->getRecords();
    foreach ($records as $record) {
        $matches = [];
        preg_match('/(\d+)\.(\d+)\.(\d{4})\s(\d+):(\d+):(\d+)/', $record[4], $matches);
        if ($matches[3] != '2021') {
            continue;
        }
        $phpDate = substr('0' . $matches[1], -2) . '-' . substr('0' . $matches[2], -2) . '-' . $matches[3] . ' ' . substr('0' . $matches[4], -2) . ':' . substr('0' . $matches[5], -2) . ':' . substr('0' . $matches[6], -2);
        $order = (new Order())->getOrderByDate($phpDate);

        $data['date'] = (new DateTime($phpDate))->format('Y.m.d H:i:s');
        $data['id'] = $order['id'];
        $data['otdel'] = $record[2];
        $data['kotype'] = $record[3];

        $data['InTotal'] = $record[5];
        $data['InSels'] = $record[6];
        $data['InDeti'] = $record[7];
        $data['InPens'] = $record[8];
        $data['InFromTotal'] = $record[9];
        $data['InFromSels'] = $record[10];
        $data['InFromDeti'] = $record[23];
        $data['InFromPens'] = $record[11];
        $data['OutToTotal'] = $record[12];
        $data['OutToSels'] = $record[13];
        $data['OutToDeti'] = $record[24];
        $data['OutToPens'] = $record[14];
        $data['OutTotal'] = $record[15];
        $data['OutSels'] = $record[16];
        $data['OutDeti'] = $record[17];
        $data['OutPens'] = $record[18];
        $data['DeadTotal'] = $record[19];
        $data['DeadSels'] = $record[20];
        $data['DeadDeti'] = $record[25];
        $data['DeadPens'] = $record[26];
        $data['DeadToday'] = $record[21];

        (new Statday())->addDay($data);
    }
} catch (Exception $e) {
    Utils::log(print_r($e, true));
}
echo 'ok';

