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
    if (!$isAdmin) {
        die;
    }
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
                <a href="plan.php" class="nav-link">План</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="dvizh.php" class="nav-link">Движения</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="reports.php" class="nav-link">Отчеты</a>
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
                        <a href="/" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Главная</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="plan.php" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>План</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dvizh.php" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Движения</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports.php" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Отчеты</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin.php" class="nav-link active">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Админка</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Админка</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Админка</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-12">

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


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Загрузка файлов в бд</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <form method="post" action="upload/upload.php" enctype="multipart/form-data"
                                          id="csvForm">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Загрузить движения</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="dvizhFile"
                                                           id="dvizhFile">
                                                    <label class="custom-file-label" for="exampleInputFile"></label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="btn input-group-text" id="uploadFile">Загрузить</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-2">
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row" id="adminResult">

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Обработки</h5>
                        </div>
                        <div class="card-body">
                            <a href="#" id="recalcRests" class="btn btn-primary">Пересчитать остатки</a>
                            <a href="#" id="fillsZeros" class="btn btn-primary">Добавление нулевых</a>
                        </div>
                        <div class="card-footer">
                            <div class="row" id="funcResult">

                            </div>
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
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>

    $(function () {
        bsCustomFileInput.init();
        $("#uploadFile").click(function () {
            let fd = new FormData();
            let files = $('#dvizhFile')[0].files;

            if (files.length > 0) {
                fd.append('file', files[0]);

                $.ajax({
                    url: 'upload/upload.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response != 0) {
                            $('.custom-file-label').html('');
                            toastr.success('Файл ' + response + ' загружен.');
                            $('#adminResult').html('Файл ' + response + ' загружен.');
                            $.ajax({
                                url: 'upload/parser.php?auth=fi34so9vhsofjs34ofh3s4o8ghp8g&file=' + response,
                                type: 'get',
                                success: function (e) {
                                    //$('#adminResult').html(e);
                                    toastr.success('Запарсено.');
                                }
                            });
                        } else {
                            toastr.error('Ошибка: файл не загружен.');
                        }
                    }
                });
            } else {
                toastr.warning('Выберите файл.');
            }
        });

        $(document).on('click', '#recalcRests', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::UPDATE_RESTS ?>,
                    data: 1
                },
                success: function (e) {
                    if (e == 'ok') {
                        toastr.success('Остатки пересчитаны.');
                    } else {
                        $('#funcResult').html(e);
                    }
                }
            })
        });
        $(document).on('click', '#fillsZeros', function () {
            $.ajax({
                url: 'ajax.php',
                method: 'GET',
                data: {
                    type: <?= Callback::FILL_ZEROS ?>,
                    data: 1
                },
                success: function (e) {
                    if (e == 'ok') {
                        toastr.success('Нули заполнены.');
                    } else {
                        $('#funcResult').html(e);
                    }
                }
            })
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
    });
</script>
</body>
</html>