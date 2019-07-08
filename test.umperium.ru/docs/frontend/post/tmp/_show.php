<?php
if ($now == date("Y-m-d", strtotime($row['published']))) {
    $published = date("H:i", strtotime($row['published']));
} else {
    $published = date("Y/m/d в H:i", strtotime($row['published']));
}
?>
    <div class="card card-body">
        <div class="row">

            <div class="col-sm-9 ml-auto">
                <a href="/user/<?php echo $row['user_id']; ?>" data-toggle="tooltip"
                   data-original-title="<?php echo $user_name; ?>" data-placement="top">
                    <img style="height:25px; width:25px;"
                         src="<?php echo FRONTEND_PATH; ?>/images/flags/<?php echo $row['code']; ?>.png" alt=""> <span
                            style="#ccc; font-size:25px;"><?php echo $row['l_name']; ?><?php echo $row['f_name']; ?></span><br></a>

                <div style="color:#b0b6bb; font-size:16px;">
                    <?php echo $published; ?> | <?php echo $row['view']; ?> <i class="mdi mdi-eye"></i>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="dropdown mb-2 mb-md-0">
                    <a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i style="font-size: 25px; color: #b0b6bb; cursor: pointer;" class="ti-more"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start"
                         style="position: absolute; transform: translate3d(0px, 27px, 0px); top: 0px; left: 0px; will-change: transform;">

                        <?php
                        if (isset($_SESSION['user'])) {
                            if ($row['user_id'] == $_SESSION['user']->id) { ?>
                                <a href="/post/edit/<?php echo $row['id']; ?>" class="dropdown-item">Изменить</a>
                                <a href="/post/delete/<?php echo $row['id']; ?>" class="dropdown-item">Удалить</a>
                            <?php } else { ?>
                                <a class="dropdown-item complain" data-toggle="modal" data-animation="bounce"
                                   data-target=".bs-example-modal-lg-2"
                                   data-id="<?php echo $row['id']; ?>">Пожаловаться</a>
                            <?php }
                        }
                        ?>


                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-sm-1">

                    </div>
                    <div class="col-sm-10">
                        <h1><?php echo $row['name']; ?></h1>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10 mx-auto ">
                <div class="content fr-view">

                    <?php
                    echo print_post_from_json($row['json']);
                    ?>

                </div>

                <div class="mb-3">
                    <?php echo $tag_list; ?>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-8 col-sm-4  ">
                <div class="repost">
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>
                    <div class="ya-share2"
                         data-services="vkontakte,facebook,odnoklassniki,twitter,viber,whatsapp,telegram"
                         data-counter=""></div>
                </div>
            </div>
            <div class="col-6 col-sm-4 d-flex align-items-center">

                <?php if (isset($_SESSION['user'])) { ?>
                    <button type="button" class="btn-sm btn-outline-info waves-effect waves-light" data-toggle="modal"
                            data-animation="bounce" data-target=".bs-example-modal-lg">Пожертвовать автору
                        <img src="/classes/thumb.php?src=http://test.umperium.ru/assets/images/umpico.png&amp;h=23&amp;w=23&amp;zc=1"
                             alt="умпериалы">
                    </button>
                <?php } else { ?>
                    <a href="/user/auth" class="btn-xs btn-outline-info waves-effect waves-light">Пожертвовать автору
                        <img src="/classes/thumb.php?src=http://test.umperium.ru/assets/images/umpico.png&amp;h=23&amp;w=23&amp;zc=1"
                             alt="умпериалы">
                    </a>
                <?php } ?>
                &nbsp
                <?php if ($row['repost_id'] == 0) { ?>
                    <a type="button" class="btn-sm btn-outline-info waves-effect waves-light"
                       href="/post/add?repost_id=<?php echo $row['id']; ?>">
                        <img src="/classes/thumb.php?src=http://test.umperium.ru/assets/images/repost.png&amp;h=23&amp;w=23&amp;zc=1"
                             alt="умпериалы">
                    </a>
                <?php } ?>
            </div>
            <div class="col-4 col-sm-2 ml-auto">
                <div class="sila">
                    <h5>
                        <a <?php if (isset($_SESSION['user'])) { ?>href="#" class="power"
                           <?php } else { ?>href="/user/auth"<?php } ?> data-id="<?php echo $row['id']; ?>"
                           data-power="down">
                            <img src="<?php echo FRONTEND_PATH; ?>/images/brain-minus.png" alt="">
                        </a>
                        <?php $color = '';
                        if ($row['power'] > 0) {
                            $color = 'color:#00a500';
                        }
                        if ($row['power'] < 0) {
                            $color = 'color:#ff4c6c';
                        }
                        ?>
                        <span class="power-count"><?php echo $row['power']; ?></span>
                        <a <?php if (isset($_SESSION['user'])) { ?>href="#" class="power"
                           <?php } else { ?>href="/user/auth"<?php } ?> data-id="<?php echo $row['id']; ?>"
                           data-power="up">
                            <img src="<?php echo FRONTEND_PATH; ?>/images/brain-plus.png" alt="">
                        </a>

                    </h5>
                </div>

            </div>
        </div>

    </div>

<?php include(ROOT_PATH . "/frontend/post/tmp/_donate_form.php"); ?>