<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo config('config.application_name') ? : config('constants.default_title'); ?></title>

    <?php echo Html::style('css/bootstrap.min.css'); ?>

    <?php echo Html::style('css/style.css'); ?>

    <?php echo Html::style('css/style-responsive.css'); ?>

    <?php echo Html::style('vendor/font-awesome/css/font-awesome.min.css'); ?>

    <?php echo Html::style('css/animate.css'); ?>

    <?php echo Html::style('css/custom.css'); ?>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container">
	    <div class="content-page">
	        <div class="body" style="width:960px;margin:0 auto;">
				    <?php echo $__env->make('invoice.invoice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	        </div>
	    </div>
	</div>
    <?php echo Html::script('js/jquery.min.js'); ?>

    <?php echo Html::script('js/bootstrap.min.js'); ?>

    <?php echo Html::script('js/wmlab.js'); ?>

  </body>
</html>

