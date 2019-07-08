<?php defined('_JEXEC') or die(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" href="<?php echo FRONTEND_PATH; ?>/images/favicon.ico">

    <link href="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link href="<?php echo FRONTEND_PATH; ?>/plugins/fullcalendar/vanillaCalendar.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo FRONTEND_PATH; ?>/plugins/morris/morris.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+SC" rel="stylesheet">

    <link href="<?php echo FRONTEND_PATH; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo FRONTEND_PATH; ?>/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo FRONTEND_PATH; ?>/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>

    <?php include_once(ROOT_PATH."/frontend/includes/header.php"); ?>

    <div class="wrapper">
        <div class="container-fluid p-0">
            <div class="row mt-2">
                <div class="col-sm-8">

                    <?php Frontend_Post_Promo_Show('_promo'); ?>

                    <!-- Nav tabs -->
                    <ul class="nav nav-pills flex-column flex-sm-row dev-cat" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#last" role="tab"><i class="ti-bolt"></i>&nbsp;&nbsp;Популярное </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#comment" role="tab"><svg style="margin-top: -2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17" id="reply" width="16" height="16">
                                    <g fill="currentColor" fill-rule="evenodd">
                                        <path d="M14.802.024H3.147C1.412.024 0 1.415 0 3.126v7.087c0 1.71 1.412 3.102 3.147 3.102h7.423l3.358 3.24a.75.75 0 0 0 1.27-.539V13.29c1.55-.192 2.75-1.5 2.75-3.077V3.126c0-1.71-1.41-3.102-3.146-3.102zm1.888 10.189c0 1.026-.847 1.861-1.888 1.861h-.233a.625.625 0 0 0-.629.62v2.188l-2.664-2.626a.634.634 0 0 0-.445-.182H3.147c-1.041 0-1.888-.835-1.888-1.861V3.126c0-1.026.847-1.861 1.888-1.861h11.655c1.041 0 1.888.835 1.888 1.86v7.088z"></path>
                                        <path d="M13.607 4.417H4.342a.625.625 0 0 0-.63.62c0 .343.283.62.63.62h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62zm0 3.474H4.342a.625.625 0 0 0-.63.62c0 .344.283.621.63.621h9.265a.624.624 0 0 0 .629-.62.625.625 0 0 0-.63-.62z"></path>
                                    </g>
                                </svg>&nbsp;&nbsp;Обсуждаемое</a>
                        </li>
                        <!--<li class="nav-item waves-effect waves-light">
						<a class="nav-link" data-toggle="tab" href="#plus18" role="tab"><i class="ion-checkmark-round"></i>&nbsp;&nbsp;Выбор редакции </a>
					</li> -->
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link " data-toggle="tab" href="#power" role="tab"><i class="ti-thumb-up"></i>&nbsp;&nbsp;Рекомендуют</a>
                        </li>
                    </ul>
                    <br>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="last" role="tabpanel">
                            <?php Frontend_Post_List('','_list_main',20,false); ?>
                        </div>

                        <div class="tab-pane p-3" id="comment" role="tabpanel">
                            <?php Frontend_Post_Comment_List('','_list_main',20,false); ?>
                        </div>
                        <div class="tab-pane p-3" id="plus18" role="tabpanel">
                            3----
                        </div>
                        <div class="tab-pane p-3" id="power" role="tabpanel">
                            <?php Frontend_Post_Power_List('','_list_main',20,false); ?>
                        </div>
                    </div>

                </div>

                <div class="col-sm-4 ">

                    <div class="card">
                        <div class="card-body">
                            <?php Frontend_Trend_List('_list',3); ?>
                        </div>
                    </div>


                    <div class="card text-white card-danger">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Власть / Политика:</h5>
                                <?php Frontend_Post_List_inCategory(1,'_list_in_category',3,false); ?>
                            </blockquote>
                        </div>
                    </div>
<div class="card">
                    <div class="card-body">
                        <div class="row">

          <div class="col-sm-5 ">

             <img style="height:75px; width: 75px; right: 10px;    margin-left: 15px; border-radius:50%!important;" src="/assets/images/earth.png" alt="user">
  </div>
           <div class="col-sm-7 ">
         
                           <h6>Стран <span class="badge badge-default">14</span></h6>
                           <h6>Сообществ <span class="badge badge-default">2</span></h6>
                           <h6>Мыслителей <span class="badge badge-default">7</span></h6>


  </div>
  </div>
    </div>
        </div>
                    <?php ?>
                    <div class="card text-white card-warning">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Медиа / СМИ</h5>
                                <?php Frontend_Post_List_inCategory(2,'_list_in_category',3,false); ?>
                            </blockquote>
                        </div>
                    </div>
                    <?php ?>

                    <div class="card bg-dark">
                        <div class="card-body">
                            <h3 class="card-title font-20 mt-0">Реклама Директ</h3>
                            <p class="card-text">Реклама</p>
                        </div>
                    </div>

                    <?php  ?>
                    <div class="card text-white card-success">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Общество / Экология</h5>
                                <?php Frontend_Post_List_inCategory(3,'_list_in_category',3,false); ?>
                            </blockquote>
                        </div>
                    </div>
                    <?php  ?>

                    <?php  ?>
                    <div class="card text-white card-info">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                               <h5>Бизнес / Экономика</h5> 
                                <?php Frontend_Post_List_inCategory(4,'_list_in_category',3,false); ?>
                            </blockquote>
                        </div>
                    </div>
                    <?php ?>

                    <?php  ?>
                    <div class="card text-white card-primary">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Техника / Транспорт </h5>
                                <?php Frontend_Post_List_inCategory(5,'_list_in_category',3,false); ?>
                            </blockquote>
                        </div>
                    </div>
                    <?php ?>
                    <div class="card text-white card-danger">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Наука / Образование </h5>
                               
                            </blockquote>
                        </div>
                    </div>
                        <div class="card bg-dark">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Путешевствия / Еда </h5>
                               
                            </blockquote>
                        </div>
                    </div>
                    <div class="card bg-dark">
                        <div class="card-body">
                            <blockquote class="card-bodyquote">
                                <h5>Корпоративные страницы </h5>
                               
                            </blockquote>
                        </div>
                    </div>








                </div>

            </div>


        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row grid-col">
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Пользовательское соглашение 


</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">О проекте</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Служба поддержки</a></div>
                                        <div class="col-sm-3"><a href="#" class="btn btn-link waves-effect" style="padding-left: 25px;">Ссылки на соцссети</a></div>                                                                         
                                    </div>
        </div>
    </footer>
    <!-- End Footer -->



    <?php include(ROOT_PATH."/frontend/includes/footer.php"); ?>

    <!-- jQuery  -->
    <script src="<?php echo FRONTEND_PATH; ?>/js/jquery.min.js"></script>

    <script type="text/javascript">
        if (~['Android', 'iPhone', 'iPod', 'iPad', 'BlackBerry'].indexOf(navigator.platform)) {
            jQuery(window).scroll(function() {

            if (jQuery(this).scrollTop() > 0) {
                jQuery('.dev-logo').fadeOut(500);
            } else {
                jQuery('.dev-logo').fadeIn(500);
            }
        });

        };
        
    </script>



    <script src="<?php echo FRONTEND_PATH; ?>/js/popper.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/js/modernizr.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/js/waves.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/js/jquery.nicescroll.js"></script>

    <script src="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <script src="<?php echo FRONTEND_PATH; ?>/plugins/skycons/skycons.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/fullcalendar/vanillaCalendar.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/raphael/raphael-min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/morris/morris.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui-slider-pips.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/jquery-ui-slider-pips.min.js?"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/pages/rangeslider-init.js"></script>

    <!-- App js -->
    <script src="<?php echo FRONTEND_PATH; ?>/js/app.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/pages/alertify-init.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/plugins/alertify/js/alertify.js"></script>
    <script src="<?php echo FRONTEND_PATH; ?>/js/promo.js"></script>

</body>

</html>
