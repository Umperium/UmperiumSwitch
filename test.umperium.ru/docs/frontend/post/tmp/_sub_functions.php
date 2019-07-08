<?php


function print_post_from_json_main($json_str)
{
    $json_obj = json_decode($json_str, true);


    if (!sizeof($json_obj)) return "";

    $requestData = array();
    foreach ($json_obj as $key => $item) {
        $requestData[$key] = $item;
    }

    $we_have_one_img = '';

    $content = '';

    $sliderArray = array();
    $indicatorArray = array();
    $img = '';

// список обьтов страницы
    for ($i = 0; $i < count($requestData); $i++) {

        $rows = (array)$requestData[$i];

        // накапливаем картинки подряд идущие в массиве от 1 до 99
        if ($rows['type'] == 'image' AND $we_have_one_img == '') {
            $cont = (array)$rows['data'];
            $cont = (array)$cont['file'];
            if (trim($cont['url']) == '') continue;

            $we_have_one_img = '<img class="d-block img-fluid" src="' . $cont['url'] . '" alt="">';
        }

        if ($rows['type'] == 'paragraph') {
            $cont = (array)$rows['data'];
            //Проверяем количество символов в посте который пришёл к нам
            //Если больше 275 режем его до 275 символов и выводим. Остальное будет только в полной ерсии поста.
        //      if ($a > 275) {
        //      $content .= Truncate($cont['text'], 10);
        //      } else {
        //     $content .= '<p>' . $cont['text'] . '</p>';
        // }
        }

        if ($rows['type'] == 'header') {
            $cont = (array)$rows['data'];
            $content .= '<h2>' . $cont['text'] . '</h2>';
        }

        if ($rows['type'] == 'quote') {
            $cont = (array)$rows['data'];
            $content .= '<blockquote>' . $cont['text'] . '</blockquote>';
        }

        if ($rows['type'] == 'list') {
            $cont = (array)$rows['data'];
            $cont = (array)$cont['file'];

            $content .= '<ul>';
            foreach ((array)$rows['data']['items'] AS $li) {
                $content .= '<li>' . $li . '</li>';
            }
            $content .= '</ul>';
        }
    }

    return $we_have_one_img . $content;
}


function print_post_from_json($json_str, $noslider = false)
{
    GLOBAL $indicatorArray, $sliderArray;
    $json_obj = json_decode($json_str, true);


    $requestData = array();
    foreach ($json_obj as $key => $item) {
        $requestData[$key] = $item;
    }
    $content = '';

    $sliderArray = array();
    $indicatorArray = array();
    $img = '';

// список обьтов страницы
    for ($i = 0; $i < count($requestData); $i++) {
        $rows = (array)$requestData[$i];
        // накапливаем картинки подряд идущие в массиве от 1 до 99
        if ($rows['type'] == 'image') {
            $cont = (array)$rows['data'];
            $cont = (array)$cont['file'];
            $active = '';
            if (count($sliderArray) == 0) {
                $active = 'active';
            }
            if (trim($cont['url']) == '') continue;

//             $sliderArray[] = '<div class="carousel-item ' . $active . '"><img class="d-block img-fluid" src="/classes/thumb.php?src=' . $cont['url'] . '&amp;h=300&amp;zc=1" alt=""></div>';
            $sliderArray[] = '<div class="carousel-item ' . $active . '"><img class="d-block img-fluid" src="' . $cont['url'] . '" alt=""></div>';
            $indicatorArray[] = true;

            $img = '<img  class="img-inpost" src="' . $cont['url'] . '" alt="">';

            //
            // если картинка последний элемент - оти выводи ее всегда
            if ($i == (count($requestData) - 1)) {
                if (count($sliderArray) > 1) {
                    // НУЖНА ГАЛЛЕРЕЯ! НО ИНОГЛДА ВВИДЕ КРАТИНКИ
                    $content .= build_gallery();
                } else {
                    $content .= $img;
                }
            }
        } else {

            // тип строки сменился на НЕ IMAGE !!!
            // проверяем не надо ли вывести галлерею
            // выводим галлерею, все кратинки есть
            if (count($sliderArray) > 1) {
                // НУЖНА ГАЛЛЕРЕЯ! НО ИНОГЛДА ВВИДЕ КРАТИНКИ
                $content .= build_gallery();
            } else {
                // одна картинка
                // одна картинка
                // одна картинка
                $content .= $img;
            }

            $sliderArray = array();
            $indicatorArray = array();
            $img = '';
        }

        if ($rows['type'] == 'paragraph') {
            $cont = (array)$rows['data'];
            $content .= '<p class="p-inpost">' . $cont['text'] . '</p>';
        }

        if ($rows['type'] == 'header') {
            $cont = (array)$rows['data'];
            $content .= '<h2 class="h2-inpost">' . $cont['text'] . '</h2>';
        }

        if ($rows['type'] == 'quote') {
            $cont = (array)$rows['data'];
            $content .= '<blockquote  class="blquote-inpost">' . $cont['text'] . '</blockquote>';
        }

        if ($rows['type'] == 'list') {
            $cont = (array)$rows['data'];
            $cont = (array)$cont['file'];

            $content .= '<ul  class="ul-inpost">';
            foreach ((array)$rows['data']['items'] AS $li) {
                $content .= '<li class=li-inpost">' . $li . '</li>';
            }
            $content .= '</ul>';
        }
    }
    return $content;
}


function build_gallery()
{
    GLOBAL $indicatorArray, $sliderArray;
    $content_ind = '';
    $i = 0;
    $j = 1;
    foreach ($indicatorArray as $indicator) {
        $active = '';
        if ($i == 0) {
            $active = 'active';
        }
        $content_ind .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="' . $active . '">' . $j . '</li>';
        $i++;
        $j++;
    }

    $id_rand = rand(0, 1000);

    $content = '<div id="carouselExampleIndicators' . $id_rand . '" class="carousel slide" data-ride="carousel">
                             <ol class="carousel-indicators">' . $content_ind . '</ol>
                             <div class="carousel-inner" role="listbox">' . implode('', $sliderArray) . '</div>
                             <a class="carousel-control-prev" href="#carouselExampleIndicators' . $id_rand . '" role="button" data-slide="prev">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 <span class="sr-only">Previous</span>
                             </a>
                             <a class="carousel-control-next" href="#carouselExampleIndicators' . $id_rand . '" role="button" data-slide="next">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 <span class="sr-only">Next</span>
                             </a>
                         </div>';


    $sliderArray = array();
    $indicatorArray = array();


    return $content;


}