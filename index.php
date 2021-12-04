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
    <title>Design | Zorg</title>

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
            <span class="brand-text font-weight-light">Design.Zorg</span>
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
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">CPU Traffic</span>
                                    <span class="info-box-number"> 10 <small>%</small> </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i
                                            class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Likes</span>
                                    <span class="info-box-number">41,410</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Sales</span>
                                    <span class="info-box-number">760</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">New Members</span>
                                    <span class="info-box-number">2,000</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Добавить платеж</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="description">Размер</label>
                                                <input type="text" class="form-control" id="amount"
                                                       placeholder="Введите размер"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="description">Описание</label>
                                                <input type="text" class="form-control" id="description"
                                                       placeholder="Введите описание"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="transferDate">Дата</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                      <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                      </span>
                                                    </div>
                                                    <input type="text"
                                                           class="form-control float-right datetimepicker-input input-add-order"
                                                           id="transferDate" data-toggle="datetimepicker"
                                                           data-target="#transferDate" placeholder="Введите дату">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group" id="phForWhat">
                                                <label for="description">За что</label>
                                                <select class="custom-select" id="forWhat">
                                                    <option value="0" selected>Не выбрано</option>
                                                    <option value="1">За сосо</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group" id="phFromWhere">
                                                <label for="description">От кого</label>
                                                <select class="custom-select" id="fromWhere">
                                                    <option value="0" selected>Не выбрано</option>
                                                    <option value="1">За сосо</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-danger" id="addOutcome">Создать расход</a>
                                    <a href="#" class="btn btn-success" id="addIncome">Создать приход</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Добавить "За что"</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="forWhatNewName">Название</label>
                                                <input type="text" class="form-control" id="forWhatNewName"
                                                       placeholder="Введите название"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary" id="addForWhat">Создать</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Добавить "От кого"</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="fromWhereNewName">Название</label>
                                                <input type="text" class="form-control" id="fromWhereNewName"
                                                       placeholder="Введите название"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-primary" id="addFromWhere">Создать</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Список платежей</h5>
                        </div>
                        <div class="card-body">
                            <table id="orderList" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Дата</th>
                                    <th>Описание</th>
                                    <th>Приход/расход</th>
                                    <th>От кого</th>
                                    <th>За что</th>
                                    <th>Размер</th>
                                </tr>
                                </thead>
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
    function reloadSelects() {
        $.ajax({
            url: 'ajax.php',
            method: 'GET',
            data: {
                type: <?= Callback::GET_SELECTS ?>,
            },
            success: function (e) {
                const _data = JSON.parse(e);
                console.log(_data);
                $('#phFromWhere').html(_data.from);
                $('#phForWhat').html(_data.for);
            }
        });
    }
    $(function () {
        reloadSelects();
        $('#transferDate').datetimepicker({
            locale: 'RU',
            timePicker: false,
            format: "DD.MM.YYYY"
        });
        $(document).on('click', '#addForWhat', function () {
            const _name = $('#forWhatNewName').val();
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::ADD_FOR ?>, data: {
                        name: _name,
                    }
                },
                success: function (e) {
                    const _data = JSON.parse(e)
                    if (e && _data.data > 0) {
                        $('#forWhatNewName').val('');
                        toastr.success('Значение создано.');
                        reloadSelects();
                        // orderTable.ajax.reload();
                    } else {
                        toastr.error('Значение не создано.');
                    }
                }
            });
        });
        $(document).on('click', '#addFromWhere', function () {
            const _name = $('#fromWhereNewName').val();
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::ADD_FROM ?>, data: {
                        name: _name,
                    }
                },
                success: function (e) {
                    const _data = JSON.parse(e)
                    if (e && _data.data > 0) {
                        $('#fromWhereNewName').val('');
                        toastr.success('Значение создано.');
                        reloadSelects();
                        // orderTable.ajax.reload();
                    } else {
                        toastr.error('Значение не создано.');
                    }
                }
            });
        });

        $(document).on('click', '#addIncome', function () {
            const _from = $('#fromWhere').val();
            const _for = $('#forWhat').val();
            const _date = $('#transferDate').val();
            const _desc = $('#description').val();
            const _amount = $('#amount').val();

            if (_from === 0 || _for === 0) {
                toastr.error('Нужно выбрать "за что" и "от кого".');
                return;
            }
            if (_date === '') {
                toastr.error('Нужно выбрать дату.');
                return;
            }
            if (_amount === '') {
                toastr.error('Нужно внести размер.');
                return;
            }
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::ADD_INCOME ?>, data: {
                        amount: _amount,
                        for: _for,
                        from: _from,
                        desc: _desc,
                        date: _date,
                    }
                },
                success: function (e) {
                    const _data = JSON.parse(e);
                    if (e && _data.data > 0) {
                        $('#amount').val('');
                        $('#description').val('');
                        toastr.success('Приход создан.');
                        // orderTable.ajax.reload();
                    } else {
                        toastr.error('Приход не создан.');
                        console.log(e);
                    }
                }
            });
            //let orderTable = $('#orderList').DataTable({
            //    "ajax": "ajax.php?type=" + <?//= Callback::GET_ORDERS ?>//,
            //    "columns": [
            //        {"data": "id"},
            //        {"data": "year"},
            //        {"data": "dateStart"},
            //        {"data": "dateEnd"},
            //        {"data": "planLech"},
            //        {"data": "planReab"},
            //        {"data": "planHoz"},
            //        {"data": "zanatost"},
            //        {"data": "avgLech"},
            //        {"data": "avgReab"},
            //        {"data": "avgHoz"},
            //        {"data": "dateAdd"}
            //    ],
            //    language: {
            //        url: 'plugins/ru.json'
            //    }
        });

        $(document).on('click', '#addOutcome', function () {
            const _from = $('#fromWhere').val();
            const _for = $('#forWhat').val();
            const _date = $('#transferDate').val();
            const _desc = $('#description').val();
            const _amount = $('#amount').val();

            if (_from === 0 || _for === 0) {
                toastr.error('Нужно выбрать "за что" и "от кого".');
                return;
            }
            if (_date === '') {
                toastr.error('Нужно выбрать дату.');
                return;
            }
            if (_amount === '') {
                toastr.error('Нужно внести размер.');
                return;
            }
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::ADD_OUTCOME ?>, data: {
                        amount: _amount,
                        for: _for,
                        from: _from,
                        desc: _desc,
                        date: _date,
                    }
                },
                success: function (e) {
                    const _data = JSON.parse(e);
                    if (e && _data.data > 0) {
                        $('#amount').val('');
                        $('#description').val('');
                        toastr.success('Приход создан.');
                        // orderTable.ajax.reload();
                    } else {
                        toastr.error('Приход не создан.');
                        console.log(e);
                    }
                }
            });
            //let orderTable = $('#orderList').DataTable({
            //    "ajax": "ajax.php?type=" + <?//= Callback::GET_ORDERS ?>//,
            //    "columns": [
            //        {"data": "id"},
            //        {"data": "year"},
            //        {"data": "dateStart"},
            //        {"data": "dateEnd"},
            //        {"data": "planLech"},
            //        {"data": "planReab"},
            //        {"data": "planHoz"},
            //        {"data": "zanatost"},
            //        {"data": "avgLech"},
            //        {"data": "avgReab"},
            //        {"data": "avgHoz"},
            //        {"data": "dateAdd"}
            //    ],
            //    language: {
            //        url: 'plugins/ru.json'
            //    }
        });
        $('#transferDate').on('change.datetimepicker', function (e) {
            console.log($('#transferDate').val().slice(-4));
            //$('#orderYear').val($('#transferDate').val().slice(-4));
        });
    })
    ;

</script>
</body>
</html>