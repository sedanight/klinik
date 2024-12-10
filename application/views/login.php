<!DOCTYPE html>
<html>

<head>

    <!-- Title -->
    <title>Login | Aplikasi Klinik</title>

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="UTF-8">
    <meta name="description" content="Aplikasi Klinik" />
    <meta name="keywords" content="admin,dashboard,login, klinik" />
    <meta name="author" content="Faiz Muhammad Syam" />

    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon-32x32.png'); ?>" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon-16x16.png'); ?>" sizes="16x16" />

    <!-- Styles -->
    <link href="<?= base_url('assets/css/css.css'); ?>" rel='stylesheet' type='text/css'>
    <link href="<?= base_url('assets/plugins/uniform/css/uniform.default.min.css'); ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/fontawesome/css/font-awesome.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/line-icons/simple-line-icons.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url('assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css'); ?>" rel="stylesheet" type="text/css"/>   -->
    <!-- <link href="<?= base_url('assets/plugins/waves/waves.min.css'); ?>" rel="stylesheet" type="text/css"/>   -->
    <link href="<?= base_url('assets/plugins/switchery/switchery.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/3d-bold-navigation/css/style.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/slidepushmenus/css/component.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/plugins/weather-icons-master/css/weather-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url('assets/plugins/metrojs/MetroJs.min.css'); ?>" rel="stylesheet" type="text/css"/>   -->
    <!-- <link href="<?= base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css"/>     -->
    <link href="<?= base_url('assets/css/sweetalert2.css') ?>" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="<?= base_url('assets/css/modern.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/white.css'); ?>" class="theme-color" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: "Helvetica, Open Sans, Tahoma, Arial", sans-serif;
        }
    </style>
    <script src="<?= base_url('assets/plugins/3d-bold-navigation/js/modernizr.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body class="page-login login-alt">
    <main class="page-content">
        <div class="page-inner">
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-6 center">
                        <div class="login-box panel panel-white">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <center><img src="<?= base_url('assets/images/hospital.png'); ?>" style="width: 30%;" alt="Logo Akademik"></center><br>
                                        <center><a href="" class="logo-name text-lg">APLIKASI KLINIK</a></center>
                                        <center>
                                            <p class="login-info"><?= $clinic->nama; ?><br><i><?= $clinic->alamat; ?></i></p>
                                        </center>
                                    </div>
                                    <div class="col-md-6">
                                        <center>
                                            <h3>Silahkan Login !</h3>
                                        </center>
                                        <form id="logmein" method="post">
                                            <div class="form-group">
                                                <input class="form-control" id="username" name="username" placeholder="Username" type="text" value="" />
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" id="password" name="password" placeholder="Password" type="password" />
                                            </div>
                                            <div class="form-group">
                                                <?= form_dropdown('shift', $shift, $shift_now, 'id=shift class="form-control"') ?>
                                            </div>
                                            <input type="button" class="btn btn-success" onclick="cek_shift();" value="Log In" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Row -->
            </div><!-- Main Wrapper -->
        </div><!-- Page Inner -->
    </main><!-- Page Content -->


    <!-- Javascripts -->
    <script src="<?= base_url('assets/plugins/jquery/jquery-2.1.4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-blockui/jquery.blockui.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/switchery/switchery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/uniform/jquery.uniform.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/waves/waves.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/3d-bold-navigation/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/js/modern.js'); ?>"></script>
    <script src="<?= base_url('assets/js/library.js') ?>"></script>
    <script src="<?= base_url() ?>assets/js/bootbox.js"></script>
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>"></script>

    <script type="text/javascript">
        $(function() {
            $('.form-control').keyup(function() {
                if ($(this).val() !== '') {
                    my_validation_remove(this);
                }
            });

            $('.form-control').change(function() {
                if ($(this).val() !== '') {
                    my_validation_remove(this);
                }
            });

            $('#username').focus();
            localStorage.setItem("menu", '');
            localStorage.setItem("nama_menu", '');
            localStorage.setItem("modul", '');

            $('#logmein').submit(function() {
                cek_shift();
            });

            $('#password').keydown(function(e) {
                if (e.keyCode === 13) {
                    cek_shift();
                }
            });
        });

        function reset_form_data() {
            $('#username').val('')
            $('#password').val('')
        }

        function cek_shift() {
            var shift_now = $('#shift').val();
            $.ajax({
                url: '<?= base_url("home/cek_shift") ?>/' + shift_now,
                dataType: 'json',
                success: function(data) {
                    var message = data.message;

                    if (data.status === false) {
                        bootbox.dialog({
                            message: message,
                            title: "Informasi",
                            buttons: {
                                batal: {
                                    label: '<i class="fa fa-refresh"></i> Sesuaikan dengan shift sekarang',
                                    className: "btn-default",
                                    callback: function() {
                                        $('#shift').val(data.shift);
                                    }
                                },
                                hapus: {
                                    label: '<i class="fa fa-trash-o"></i>  Lanjutkan',
                                    className: "btn-primary",
                                    callback: function() {
                                        logmein();
                                    }
                                }
                            }
                        });

                    } else {
                        logmein();
                    }
                }
            });
        }

        function logmein() {
            var stop = false;

            if ($('#username').val() === '') {
                my_validation('#username', 'Username tidak boleh kosong!');
                stop = true;
            };

            if ($('#password').val() === '') {
                my_validation('#password', 'Password tidak boleh kosong!');
                stop = true;
            };

            if (stop) {
                return false;
            }
            //if ($('#username').val() !== '' && $('#password').val() !== '') {
            $.ajax({
                url: '<?= base_url("users/logmein") ?>',
                data: $('#logmein').serialize(),
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // alert(data.status);
                    if (data.status == true) {
                        location.reload();
                    } else if (data.passwrong == false) {
                        // message_custom('error', 'Password salah');
                        my_validation('#password', 'Password anda salah!');
                        // reset_form_data();
                    } else if (data.status == false) {
                        // location.reload();
                        my_validation('#username', 'Username anda salah!');
                        // reset_form_data();
                    }
                }
            });
            //}
        }
    </script>
</body>

</html>