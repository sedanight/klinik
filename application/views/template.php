<!DOCTYPE html>
<html>

<head>

    <!-- Title -->
    <title>Aplikasi Klinik | Phoenix <?= date('Y'); ?> </title>

    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta charset="UTF-8">
    <meta name="description" content="Admin Dashboard Aplikasi Klinik" />
    <meta name="keywords" content="admin,dashboard,aplikasi klinik, klinik, farmasi" />
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
    <link href="<?= base_url('assets/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- <link href="<?= base_url('assets/plugins/metrojs/MetroJs.min.css'); ?>" rel="stylesheet" type="text/css"/>   -->
    <!-- <link href="<?= base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css"/>     -->
    <link href="<?= base_url('assets/css/sweetalert2.css') ?>" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="<?= base_url('assets/css/modern.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/themes/green.css'); ?>" class="theme-color" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/css/select2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/select2.css'); ?>" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: "Helvetica, Tahoma, Arial", sans-serif;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body class="page-sidebar-fixed page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="sidebar-pusher">
                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="logo-box">
                    <a href="javascript:0" onclick="gotohome()" class="logo-text"><span>HOME</span></a>
                </div><!-- Logo Box -->
                <div class="topmenu-outer">
                    <div class="top-menu">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                    <i class="fa fa-cogs"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-md dropdown-list theme-settings" role="menu">
                                    <li class="li-group">
                                        <ul class="list-unstyled">
                                            <li class="no-link" role="presentation">
                                                Fixed Header
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right fixed-header-check" checked>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="li-group">
                                        <ul class="list-unstyled">
                                            <li class="no-link" role="presentation">
                                                Fixed Sidebar
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right fixed-sidebar-check">
                                                </div>
                                            </li>
                                            <li class="no-link" role="presentation">
                                                Horizontal bar
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right horizontal-bar-check">
                                                </div>
                                            </li>
                                            <li class="no-link" role="presentation">
                                                Toggle Sidebar
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right toggle-sidebar-check">
                                                </div>
                                            </li>
                                            <li class="no-link" role="presentation">
                                                Compact Menu
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right compact-menu-check">
                                                </div>
                                            </li>
                                            <li class="no-link" role="presentation">
                                                Hover Menu
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right hover-menu-check">
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="li-group">
                                        <ul class="list-unstyled">
                                            <li class="no-link" role="presentation">
                                                Boxed Layout
                                                <div class="ios-switch pull-right switch-md">
                                                    <input type="checkbox" class="js-switch pull-right boxed-layout-check">
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="li-group">
                                        <ul class="list-unstyled">
                                            <li class="no-link" role="presentation">
                                                Choose Theme Color
                                                <div class="color-switcher">
                                                    <a class="colorbox color-blue" href="?theme=blue" title="Blue Theme" data-css="blue"></a>
                                                    <a class="colorbox color-green" href="?theme=green" title="Green Theme" data-css="green"></a>
                                                    <a class="colorbox color-red" href="?theme=red" title="Red Theme" data-css="red"></a>
                                                    <a class="colorbox color-white" href="?theme=white" title="White Theme" data-css="white"></a>
                                                    <a class="colorbox color-purple" href="?theme=purple" title="purple Theme" data-css="purple"></a>
                                                    <a class="colorbox color-dark" href="?theme=dark" title="Dark Theme" data-css="dark"></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="no-link"><button class="btn btn-default reset-options">Reset Options</button></li>
                                </ul>
                            </li>
                            <li>
                                <a id="jam" class="waves-effect waves-button waves-classic"></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                    <span class="user-name"><?= $this->session->userdata('nama'); ?><i class="fa fa-angle-down"></i></span>
                                    <?php if ($profil == '') : ?>
                                        <img class="img-circle avatar" src="<?= base_url('assets/images/admin.png') ?>" width="40" height="40" alt="">
                                    <?php else : ?>
                                        <img class="img-circle avatar" src="<?= base_url('assets/foto/') ?><?= $profil->nama; ?>" width="40" height="40" alt="">
                                    <?php endif ?>

                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation"><a href="javascript:0" onclick="load_menu('home/profile', 'Dashboard','Profile', 'Profile'); return false;"><i class="fa fa-user"></i>Profile</a></li>
                                    <li role="presentation"><a href="javascript:0" onclick="load_menu('home/ganti_password', 'Dashboard','Password', 'Ganti Password'); return false;"><i class="fa fa-refresh"></i>Ganti Password</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a href="javascript:0" onclick="location.href='<?= base_url('users/logout') ?>'"><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:0" onclick="location.href='<?= base_url('users/logout') ?>'" class="log-out waves-effect waves-button waves-classic">
                                    <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                </a>
                            </li>
                        </ul><!-- Nav -->
                    </div><!-- Top Menu -->
                </div>
            </div>
        </div><!-- Navbar -->
        <div class="sidebar page-sidebar">
            <div class="page-sidebar-inner slimscroll">
                <div class="sidebar-header">
                    <div class="sidebar-profile">
                        <a href="javascript:void(0);" id="profile-menu-link">
                            <div class="sidebar-profile-image">
                                <?php if ($profil == '') : ?>
                                    <img src="<?= base_url('assets/images/admin.png') ?>" class="img-circle img-responsive" alt="Template Admin Foto" style="width: 80px; height: 80px;">
                                <?php else : ?>
                                    <img src="<?= base_url('assets/foto/') ?><?= $profil->nama; ?>" class="img-circle img-responsive" alt="<?= $profil->nama; ?>" style="width: 80px; height: 80px;">
                                <?php endif ?>
                            </div>
                            <div class="sidebar-profile-details">
                                <span><?= $this->session->userdata('nama') ?><br><small><?= $this->session->userdata('profesi') ?></small></span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Menu -->
                <ul class="menu accordion-menu">
                    <?php foreach ($module as $key => $mod) {
                        $activ = "";
                        $modul = "";
                        $current = "";

                        if ($active == $mod->nama) {
                            $activ = "";
                        } else {
                            $modul = $mod->controller;
                        }

                        $privileges = $this->M_home->get_data_privileges($this->session->userdata('id_group'), $mod->id);
                        $module_url = str_replace(' ', '', strtolower($mod->nama))
                        ?>
                        <li class="droplink"><a href="javascript:0" class="waves-effect waves-button"><span class="menu-icon <?= $mod->icon; ?>"></span>
                                <p><?= $mod->nama; ?></p><span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php
                                if (sizeof($privileges) > 0) {
                                    foreach ($privileges as $key2 => $value2) { ?>
                                        <li>
                                            <a href="javascript:0" onclick="load_menu('<?= $value2->url ?>', '<?= $mod->nama ?>','<?= $modul ?>', '<?= $value2->menu ?>'); return false;"><?= $value2->menu ?></a>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        </li>

                    <?php } ?>
                    <!-- <li class="active"><a href="index.html" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li> -->

                </ul>
                <!-- Menu -->

            </div><!-- Page Sidebar Inner -->
        </div><!-- Page Sidebar -->
        <div class="page-inner">
            <div class="page-title">
                <h3 id="title_menu">Dashboard</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li>Home</li>
                        <li id="active"><?= $active; ?></li>
                        <li id="breadcumb_menu"></li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div id="main_content">

                </div>
            </div><!-- Main Wrapper -->


            <div class="page-footer" style="position: fixed;">
                <p class="no-s"><?= date('Y'); ?> &copy; Aplikasi Klinik Development.</p>
            </div>
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    <div class="cd-overlay"></div>


    <!-- Javascripts -->
    <script src="<?= base_url('assets/plugins/jquery/jquery-2.1.4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <!-- <script src="<?= base_url('assets/plugins/pace-master/pace.min.js'); ?>"></script> -->
    <script src="<?= base_url('assets/plugins/jquery-blockui/jquery.blockui.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/switchery/switchery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/uniform/jquery.uniform.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/offcanvasmenueffects/js/classie.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/offcanvasmenueffects/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/waves/waves.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/3d-bold-navigation/js/main.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/waypoints/jquery.waypoints.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-counterup/jquery.counterup.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/flot/jquery.flot.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/flot/jquery.flot.time.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/flot/jquery.flot.symbol.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/flot/jquery.flot.resize.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/flot/jquery.flot.tooltip.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/curvedlines/curvedLines.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/metrojs/MetroJs.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/modern.js'); ?>"></script>
    <script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/library.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.multilevelpushmenu.js') ?>"></script>
    <script src="<?= base_url('assets/js/select2.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/select2.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootbox.js') ?>"></script>
    <script src="<?= base_url('assets/dropzone/dist/min/dropzone.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/timeago/dist/timeago.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/3d-bold-navigation/js/modernizr.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/chartsjs/Chart.min.js'); ?>"></script>
    <script src="<?= base_url('assets/highchart/highcharts.js') ?>"></script>
    <script src="<?= base_url('assets/js/js-cookie/src/js.cookie.js'); ?>"></script>

    <script>
        var dWidth = $(window).width();
        var dHeight = $(window).height();
        var x = screen.width / 2 - dWidth / 2;
        var y = screen.height / 2 - dHeight / 2;

        function show_ajax_loading() {
            $('body').block({
                message: '<span><img src="<?= base_url() ?>assets/images/loading.gif" />&nbsp;&nbsp;Loading ...</span>',
                css: {
                    border: '1px solid #ccc',
                    padding: '5px',
                    position: 'fixed',
                    backgroundColor: '#f4f4f4',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: 1,
                    width: '120px',
                    color: '#000'
                },

                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0,
                    cursor: 'wait',
                    overflowY: 'hidden',
                    position: 'fixed'
                },
            });
        }

        function show_ajax_with_message(msg) {
            $('body').block({
                message: '<span><img src="<?= base_url() ?>assets/img/loading.gif" /> ' + msg + '</span>',
                css: {
                    border: '1px solid #b5b5b5',
                    padding: '5px',
                    backgroundColor: '#f4f4f4',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: 1,
                    width: 'auto',
                    color: '#000'
                }
            });
        }

        function hide_ajax_loading() {
            $('body').unblock();
        }

        function load_modul(url) {
            localStorage.setItem("menu", '');
            localStorage.setItem("nama_menu", '');
            location.href = url;
        }

        function gotohome() {
            localStorage.setItem("menu", '');
            localStorage.setItem("nama_menu", '');
            localStorage.setItem("modul", '');
            location.href = '<?= base_url() ?>';
        }

        function load_menu(url, nama_modul, modul, menu) {
            localStorage.setItem("menu", '<?= base_url("'+url+'") ?>');
            localStorage.setItem("nama_menu", menu);
            localStorage.setItem("modul", nama_modul);
            set_title_page(menu, nama_modul);
            $.ajax({
                url: '<?= base_url("'+url+'") ?>',
                data: '',
                cache: false,
                success: function(data) {
                    //$('form').remove();
                    $('#main_content').empty();
                    $('#main_content').html(data);
                }
            });
        }

        function set_title_page(menu, nama_menu) {
            $('#title_menu').html(strip(menu));
            $('#active').html(strip(nama_menu));
            $('#breadcumb_menu').html(strip(menu));
        }

        function clock() {
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];

            var date = new Date();
            var day = date.getDate();
            var month = date.getMonth();
            var thisDay = date.getDay(),
                thisDay = myDays[thisDay];

            var yy = date.getYear();

            var year = (yy < 1000) ? yy + 1900 : yy;

            var Hari = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
            //document.write();

            var now = new Date();
            var secs = ('0' + now.getSeconds()).slice(-2);
            var mins = ('0' + now.getMinutes()).slice(-2);
            var hr = ('0' + now.getHours()).slice(-2);
            var Time = " - Jam : " + hr + " : " + mins + " : " + secs + " WIB";
            document.getElementById("jam").innerHTML = Hari + Time;
            requestAnimationFrame(clock);
        }

        $(function() {

            requestAnimationFrame(clock);

            $('body').ajaxError(function(e, jqxhr, settings, exception) {
                var url = settings.url;
                var res = jqxhr.responseText;
                var status = jqxhr.statusText;
                var status_code = jqxhr.status;
                var menu = localStorage.getItem("nama_menu");
                //console.log($(res).find('body'));

                $.each($.parseHTML(res), function(i, el) {
                    if (el.nodeName == 'DIV') {
                        res = $(el).html();
                    };

                });

                if (status_code === 401) {
                    // un authoized
                    bootbox.dialog({
                        message: "Session login anda habis, silahkan login lagi",
                        title: "Session Timeout",
                        buttons: {
                            ok: {
                                label: '<i class="fa fa-check"></i> OK',
                                className: "btn-primary",
                                callback: function() {
                                    location.reload();
                                }
                            }
                        }
                    });
                    return false;
                }

                if (status_code !== 404) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url("api/sistem/log") ?>',
                        data: "url=" + url + "&response=" + res + "&status=" + status + "&menu=" + menu,
                        cache: false,
                        success: function(data) {
                            location.reload();
                        }
                    });
                } else {
                    // message_custom('info', 'Informase', 'Data tidak ditemukan','');
                }

            });

            $('#menu').multilevelpushmenu({
                containersToPush: [$('#pushobj')],
                backText: 'Kembali'
            });

            if (localStorage.getItem("modul") !== '') {
                $('#menu').multilevelpushmenu('expand', localStorage.getItem("modul"));
            };

            if ('<?= $active ?>' == '') {
                localStorage.setItem("menu", '');
                localStorage.setItem("nama_menu", '');
                localStorage.setItem("modul", '');
            };

            var height = $(window).height();
            $('.dashboard-wrapper').css('min-height', height - 55 + 'px');


            var menu = '';
            if (localStorage.getItem("menu") === '') {
                menu = '';
            } else {
                menu = localStorage.getItem("menu");
            }

            var modul = localStorage.getItem("modul");
            var nama_menu = localStorage.getItem("nama_menu");

            if (nama_menu !== '') {
                set_title_page(nama_menu, modul);
            } else {
                //set_title_page('');
            }
            if (menu !== '') {
                $.ajax({
                    url: menu,
                    data: '',
                    cache: false,
                    success: function(data) {
                        $('#main_content').empty();
                        $('#main_content').html(data);
                    }
                });
            } else {
                $.ajax({
                    url: '<?= base_url("home/home_page"); ?>',
                    data: '',
                    cache: false,
                    success: function(data) {
                        $('#main_content').empty();
                        $('#main_content').html(data);
                    }
                });
            }
        });
    </script>
</body>

</html>