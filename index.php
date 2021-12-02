<?

use classes\User;
use classes\DB;
use classes\Callback;

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_set_cookie_params(30800);
session_start();

if (!$_SESSION["enter"]) {
    header("Location: login.php");
}

if ($_REQUEST["action"] == "exit") {
    header("Location: login.php");
    session_destroy();
}

$db = new DB();

$uid = $_SESSION["us_id"];
$USER = [
    'name' => User::getFullname($uid),
    'type' => User::getType($uid),
    'rig' => User::getRights($uid),
    'id' => $_SESSION["us_id"],
];
$isAdmin = $USER['type'] == 1;
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ОНД | Статистика</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Главная</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="stat.php" class="nav-link">Статистика</a>
            </li>
            <? if ($isAdmin) { ?>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="admin.php" class="nav-link">Админка</a>
                </li>
            <? } ?>
        </ul>

    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index3.html" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Статистика</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="/" class="nav-link active">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Главная</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="stat.php" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Статистика</p>
                        </a>
                    </li>
                    <? if ($isAdmin) { ?>
                        <li class="nav-item">
                            <a href="admin.php" class="nav-link">
                                <i class="nav-icon fas fa-angle-double-right"></i>
                                <p>Админка</p>
                            </a>
                        </li>
                    <? } ?>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Главная</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Главная</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-12">

                    <? if ($isAdmin) { ?>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <a href="#" id="btnTest1" class="btn btn-primary">otdelko table</a>
                                <a href="#" id="btnTest2" class="btn btn-primary">clear orders + 1st</a>
                                <a href="#" id="btnTest3" class="btn btn-primary">add 2nd order</a>
                                <a href="#" id="btnTest4" class="btn btn-primary">select test</a>
                                <a href="#" id="btnTest5" class="btn btn-primary">orderostatok table</a>
                            </div>
                            <div class="card-body" id="testRes">

                            </div>
                        </div>
                    <? } ?>

                    <div class="card collapsed-card">
                        <div class="card-header" data-card-widget="collapse">
                            <h5 class="card-title">Добавить приказ</h5>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="orderYear">Год приказа</label>
                                        <input type="text" class="form-control" id="orderYear" placeholder="Введите год"
                                               value="2021" disabled>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="orderFromDate">Действует с</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                          <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                          </span>
                                            </div>
                                            <input type="text"
                                                   class="form-control float-right datetimepicker-input input-add-order"
                                                   id="orderFromDate" data-toggle="datetimepicker"
                                                   data-target="#orderFromDate" placeholder="Введите дату">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <!--                                    <div class="form-group">-->
                                    <!--                                        <label for="orderZan">Занятость койки</label>-->
                                    <!--                                        <input type="text" class="form-control" id="orderZan"-->
                                    <!--                                               placeholder="Введите число"-->
                                    <!--                                               value="0">-->
                                    <!--                                    </div>-->
                                </div>
                                <div class="col-6">
                                    <div class="callout callout-success">
                                        <h5>Койки по отделениям:</h5>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">1-ое отделение:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="otdel1LechKo"
                                                   placeholder="Лечебные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel1ReabKo"
                                                   placeholder="Реабилитационные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel1HozKo"
                                                   placeholder="Хоз-расчетные"
                                                   value="">
                                        </div>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">2-ое отделение:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="otdel2LechKo"
                                                   placeholder="Лечебные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel2ReabKo"
                                                   placeholder="Реабилитационные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel2HozKo"
                                                   placeholder="Хоз-расчетные"
                                                   value="">
                                        </div>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">3-ье отделение:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="otdel3LechKo"
                                                   placeholder="Лечебные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel3ReabKo"
                                                   placeholder="Реабилитационные"
                                                   value="">
                                            <input type="text" class="form-control input-add-order" id="otdel3HozKo"
                                                   placeholder="Хоз-расчетные"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="callout callout-success">
                                        <h5>Планово пролечить пациентов:</h5>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Лечебные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="orderPlanLech"
                                                   value="0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Реабилитационные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="orderPlanReab"
                                                   value="0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Хоз-расчетные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="orderPlanHoz"
                                                   value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="callout callout-success">
                                        <h5>Койко-дни план:</h5>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Лечебные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="kodnLech"
                                                   value="0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Реабилитационные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="kodnReab"
                                                   value="0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Хоз-расчетные:</span>
                                            </div>
                                            <input type="text" class="form-control input-add-order" id="kodnHoz"
                                                   value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                </div>

                                <div class="col-6">
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary" id="addOrder">Создать приказ</a>
                        </div>
                        <div class="card-footer">
                            <div class="row" id="orderAddResult">

                            </div>
                        </div>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Список приказов</h5>
                        </div>
                        <div class="card-body">
                            <table id="orderList" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Год</th>
                                    <th>Начало</th>
                                    <th>Конец</th>
                                    <th>План леч. коек</th>
                                    <th>План реаб. коек</th>
                                    <th>План хоз. коек</th>
                                    <th>Занятость</th>
                                    <th>Сред. леч. коек</th>
                                    <th>Сред. реаб. коек</th>
                                    <th>Сред. хоз. коек</th>
                                    <th>Дата создания</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Год</th>
                                    <th>Начало</th>
                                    <th>Конец</th>
                                    <th>План леч. коек</th>
                                    <th>План реаб. коек</th>
                                    <th>План хоз. коек</th>
                                    <th>Занятость</th>
                                    <th>Сред. леч. коек</th>
                                    <th>Сред. реаб. коек</th>
                                    <th>Сред. хоз. коек</th>
                                    <th>Дата создания</th>
                                </tr>
                                </tfoot>
                            </table>
                            <a href="#" id="refreshOrderList" class="btn btn-primary">Обновить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            ОНД | Статистика
        </div>
        <strong>Copyright &copy; 2014-2021
            <a href="https://adminlte.io">AdminLTE.io</a>
            .</strong> All rights reserved.
    </footer>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
    $(function () {
        $('#orderFromDate').datetimepicker({
            locale: 'RU',
            timePicker: false,
            format: "DD.MM.YYYY"
        });
        $(document).on('click', '#btnTest1', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: 'test',
                    test: 1
                },
                success: function (e) {
                    $('#testRes').html(e);
                    toastr.success('Приказ создан.');
                }
            })
        });
        $(document).on('click', '#btnTest2', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: 'test',
                    test: 2
                },
                success: function (e) {
                    $('#testRes').html(e);
                    orderTable.ajax.reload();
                }
            })
        });
        $(document).on('click', '#btnTest3', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: 'test',
                    test: 3
                },
                success: function (e) {
                    $('#testRes').html(e);
                    orderTable.ajax.reload();
                }
            })
        });
        $(document).on('click', '#btnTest4', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: 'test',
                    test: 4
                },
                success: function (e) {
                    $('#testRes').html(e);
                }
            })
        });
        $(document).on('click', '#btnTest5', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: 'test',
                    test: 5
                },
                success: function (e) {
                    $('#testRes').html(e);
                }
            })
        });
        $(document).on('click', '#addOrder', function () {
            let lechKo = parseInt($('#otdel1LechKo').val()) + parseInt($('#otdel2LechKo').val()) + parseInt($('#otdel3LechKo').val());
            let reabKo = parseInt($('#otdel1ReabKo').val()) + parseInt($('#otdel2ReabKo').val()) + parseInt($('#otdel3ReabKo').val());
            let zan = parseInt($('#orderZan').val());
            let planLech = parseInt($('#orderPlanLech').val());
            let planReab = parseInt($('#orderPlanReab').val());
            let avgLech = lechKo * zan / planLech;
            let avgReab = reabKo * zan / planReab;
            $('#orderAvgLech').val(avgLech);
            $('#orderAvgReab').val(avgReab);
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::ADD_ORDER ?>, data: {
                        year: $('#orderYear').val(),
                        dateStart: $('#orderFromDate').val(),
                        //zanatost: $('#orderZan').val(),
                        planLech: $('#orderPlanLech').val(),
                        planReab: $('#orderPlanReab').val(),
                        planHoz: $('#orderPlanHoz').val(),
                        kodnLech: $('#kodnLech').val(),
                        kodnReab: $('#kodnReab').val(),
                        kodnHoz: $('#kodnHoz').val(),
                        otdel1LechKo: $('#otdel1LechKo').val(),
                        otdel1ReabKo: $('#otdel1ReabKo').val(),
                        otdel1HozKo: $('#otdel1HozKo').val(),
                        otdel2LechKo: $('#otdel2LechKo').val(),
                        otdel2ReabKo: $('#otdel2ReabKo').val(),
                        otdel2HozKo: $('#otdel2HozKo').val(),
                        otdel3LechKo: $('#otdel3LechKo').val(),
                        otdel3ReabKo: $('#otdel3ReabKo').val(),
                        otdel3HozKo: $('#otdel3HozKo').val()
                    }
                },
                success: function (e) {
                    if (e.toString() == 'ok') {
                        $('#orderAddResult').html('Приказ успешно создан!');
                        toastr.success('Приказ создан.');
                        orderTable.ajax.reload();
                    } else {
                        toastr.error('Приказ не создан.');
                        $('#orderAddResult').html('<pre>ОШИБКА:\r\n' + e + '</pre>');
                    }
                }
            });
        });
        let orderTable = $('#orderList').DataTable({
            "ajax": "ajax.php?type=" + <?= Callback::GET_ORDERS ?>,
            "columns": [
                {"data": "id"},
                {"data": "year"},
                {"data": "dateStart"},
                {"data": "dateEnd"},
                {"data": "planLech"},
                {"data": "planReab"},
                {"data": "planHoz"},
                {"data": "zanatost"},
                {"data": "avgLech"},
                {"data": "avgReab"},
                {"data": "avgHoz"},
                {"data": "dateAdd"}
            ],
            language: {
                url: 'plugins/ru.json'
            }
        });
        $('#orderFromDate').on('change.datetimepicker', function (e) {
            $('#orderYear').val($('#orderFromDate').val().slice(-4));
        });
    });

</script>
</body>
</html>