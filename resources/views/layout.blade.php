<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Mainers</title>

    <meta name="description" content="Static &amp; Dynamic Tables" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="/public/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/public/assets/font-awesome/4.2.0/css/font-awesome.min.css" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="/public/assets/fonts/fonts.googleapis.com.css" />

<!-- ace styles -->
    <link rel="stylesheet" href="/public/assets/css/ace.min.css?2" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/public/assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <![endif]-->

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/public/assets/css/ace-ie.min.css" />
    <![endif]-->

    <link rel="stylesheet" href="/public/assets/css/datepicker.min.css" />
    <link rel="stylesheet" href="/public/assets/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="/public/assets/css/daterangepicker.min.css" />


    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="/public/assets/js/ace-extra.min.js"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="/public/assets/js/html5shiv.min.js"></script>
    <script src="/public/assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="/public/assets/js/jquery.2.1.1.min.js"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="/public/assets/js/jquery.1.11.1.min.js"></script>
    <![endif]-->

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/public/assets/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/public/assets/js/jquery1x.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='/public/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/public/assets/js/bootstrap.min.js"></script>

    <!-- page specific plugin scripts -->

    <!-- ace scripts -->
    <script src="/public/assets/js/ace-elements.min.js"></script>
    <script src="/public/assets/js/ace.min.js"></script>




    <script src="/public/assets/js/fuelux.spinner.min.js"></script>
    <script src="/public/assets/js/moment.min.js"></script>
    <script src="/public/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/public/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/public/assets/js/daterangepicker.min.js"></script>

</head>

<body class="no-skin">

<div class="main-container" id="main-container">
    <div class="main-content">
        <div class="main-content-inner">
            @yield('main')
        </div>
    </div><!-- /.main-content -->

</div><!-- /.main-container -->

</body>
</html>
