<!DOCTYPE html>
<html>
    <head>
    <title><?php echo config('config.application_name') ? : config('constants.default_title'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <?php echo Html::style('css/bootstrap.min.css'); ?>

    <?php echo HTML::style('vendor/jquery-ui/jquery-ui.min.css'); ?>

    <?php echo Html::style('css/style.css'); ?>

    <?php echo Html::style('css/style-responsive.css'); ?>

    <?php echo Html::style('css/animate.css'); ?>

    <?php echo HTML::style('vendor/toastr/toastr.min.css'); ?>


    <?php if(isset($direction) && $direction == 'rtl'): ?>
    <?php echo HTML::style('css/bootstrap-rtl.css'); ?>

    <?php echo HTML::style('css/bootstrap-flipped.css'); ?>

    <?php echo HTML::style('css/style-right.css'); ?>

    <?php endif; ?>

    <?php echo Html::style('vendor/font-awesome/css/font-awesome.min.css'); ?>

    <?php echo Html::style('vendor/sortable/sortable-theme-bootstrap.css'); ?>

    <?php echo Html::style('vendor/icheck/skins/flat/blue.css'); ?>

    <?php echo Html::style('vendor/select/css/bootstrap-select.min.css'); ?>

    <?php echo Html::style('vendor/switch/bootstrap-switch.min.css'); ?>

    <?php echo Html::style('vendor/datepicker/css/datepicker.css'); ?>

    <?php if(isset($assets) && in_array('datatable',$assets)): ?>
        <?php echo Html::style('vendor/datatables/datatables.min.css'); ?>

    <?php endif; ?>
    <?php if(isset($assets) && in_array('calendar',$assets)): ?>
        <?php echo Html::style('vendor/calendar/fullcalendar.min.css'); ?>

    <?php endif; ?>
    <?php if(isset($assets) && in_array('tags',$assets)): ?>
        <?php echo Html::style('vendor/tags/tags.css'); ?>

    <?php endif; ?>
    <?php if(isset($assets) && in_array('redactor',$assets)): ?>
        <?php echo Html::style('vendor/redactor/redactor.css'); ?>

    <?php endif; ?>
    <?php echo Html::style('vendor/page/page.css'); ?>

    <?php if(isset($assets) && in_array('summernote',$assets)): ?>
        <?php echo Html::style('vendor/summernote/summernote.css'); ?>

    <?php endif; ?>
    <?php echo Html::style('css/custom.css'); ?>

    <?php echo Html::style('css/color-scheme/'.config('config.theme_color').'.css'); ?>


    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo e(config('config.theme_font')); ?>">
    <style>
        *{font-family: <?php echo e(config('config.theme_font')); ?>,'Verdana';}
        h2{font-family: <?php echo e(config('config.theme_font')); ?>,'Verdana'; font-weight:normal;}
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- <link rel="shortcut icon" href="<?php echo url('images/favicon.ico'); ?>"> -->
    </head>