<?php
defined('_JEXEC') or die();


function Frontend_Post_Part()
{
    global $DBH;
    global $ROUTE;

    /* Лента */
    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'post') {

        $title = 'Лента';
        $name = 'Лента';

        require_once(ROOT_PATH . "/frontend/post/tmp/listSuccess.php");
        return false;
    }

    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'elite') {

        $title = 'Лента';
        $name = 'Лента';

        require_once(ROOT_PATH . "/frontend/post/tmp/listSuccess.php");
        return false;
    }

    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'repost') {

        $title = 'Лента';
        $name = 'Лента';

        require_once(ROOT_PATH . "/frontend/post/tmp/listSuccess.php");
        return false;
    }


    /* Добавление */
    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'add') {
        if (Frontend_User_ifAuth()) {

            Frontend_Post_Add();

            $title = 'Добавление публикации';
            $name = 'Добавление публикации';

            require_once(ROOT_PATH . "/frontend/post/tmp/formSuccess.php");
            return false;
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }

    if ($ROUTE['controller'] == 'post' && $ROUTE['action'] == 'upload' && $ROUTE['id'] == 'image') {
        Frontend_Post_Image_Upload();
        die();
    }

    /* Показать */
    if ($ROUTE['controller'] == 'post' && $ROUTE['action'] == $ROUTE['id']) {

        $data = array('slug' => $ROUTE['id'], 'is_active' => 1);
        $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post WHERE slug = :slug AND is_active = :is_active ");
        $CHECK->execute($data);

        if ($CHECK->fetchColumn() > 0) {

            $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post WHERE slug = :slug AND is_active = :is_active ");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
            $row = $RESULT->fetch();


            $title = $row['name'];
            $name = $row['name'];
            $id = $row['id'];

            require_once(ROOT_PATH . "/frontend/post/tmp/showSuccess.php");
            return false;
        }
    }

    /* Изменение */
    if ($ROUTE['controller'] == 'post' && $ROUTE['action'] == 'edit' && is_numeric($ROUTE['id'])) {
        if (Frontend_User_ifAuth()) {

            $user_id = $_SESSION['user']->id;

            $data = array('id' => $ROUTE['id'], 'user_id' => $user_id);
            $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post WHERE id = :id AND user_id = :user_id ");
            $CHECK->execute($data);

            if ($CHECK->fetchColumn() > 0) {

                Frontend_Post_Edit($ROUTE['id']);

                $title = 'Изменение публикации';
                $name = 'Изменение публикации';

                $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post WHERE id = :id AND user_id = :user_id ");
                $RESULT->execute($data);
                $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                $row = $RESULT->fetch();


                $data = array('id' => $ROUTE['id']);
                $RESULT_TAG = $DBH->prepare("SELECT " . DB_PREFIX . "tag.* FROM " . DB_PREFIX . "tag 
				INNER JOIN " . DB_PREFIX . "post_tag ON " . DB_PREFIX . "post_tag.tag_id = " . DB_PREFIX . "tag.id
				WHERE " . DB_PREFIX . "post_tag.post_id = :id");
                $RESULT_TAG->execute($data);
                $RESULT_TAG->setFetchMode(PDO::FETCH_ASSOC);

                $tag_list = '';
                while ($row_tag = $RESULT_TAG->fetch()) {
                    $tag_list .= $row_tag['name'] . ' ';
                }
                $tag_list = trim($tag_list);

                require_once(ROOT_PATH . "/frontend/post/tmp/formSuccess.php");
                return false;
            }
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }

    if ($ROUTE['controller'] == 'post' && $ROUTE['action'] == 'delete' && is_numeric($ROUTE['id'])) {
        if (Frontend_User_ifAuth()) {

            $user_id = $_SESSION['user']->id;

            $data = array('id' => $ROUTE['id'], 'user_id' => $user_id);
            $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post WHERE id = :id AND user_id = :user_id ");
            $CHECK->execute($data);

            if ($CHECK->fetchColumn() > 0) {

                $data = array('id' => $ROUTE['id']);
                $DELETE = $DBH->prepare("DELETE FROM " . DB_PREFIX . "post WHERE id = :id ");
                $DELETE->execute($data);

                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /");
                exit();

            }
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }

    /* Промо */
    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'promo') {
        if (Frontend_User_ifAuth()) {
            Frontend_Post_Promo();
            die();
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }


    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'buy') {
        if (Frontend_User_ifAuth()) {
            Frontend_Post_Buy();
            die();
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }

    /* Донат */
    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'donate') {
        if (Frontend_User_ifAuth()) {
            Frontend_Post_Donate();
            die();
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }


    if ($ROUTE['controller'] == 'post' && $ROUTE['id'] == 'power') {
        if (Frontend_User_ifAuth()) {
            Frontend_Post_Power();
            die();
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /user/auth");
            exit();
        }
    }


    // // header("HTTP/1.1 301 Moved Permanently");
    // // header("Location: /404");
    // exit();
}


function Frontend_Post_List($id, $tmp, $count, $pager = false)
{
    global $DBH;


    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    if (empty($id)) {


        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE repost_id = 0 ");
        $CHECK->execute();
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }


            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;



            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code 
			FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE p.repost_id = 0
			ORDER BY p.published DESC LIMIT $start, $count");
            $RESULT->execute();
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    } else {

        $data = array('user_id' => $id);
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE user_id = :user_id ");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;

            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code  
			FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE p.user_id = :user_id 
			ORDER BY p.published DESC LIMIT $start, $count");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    }

    if ($items > 0) {
        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        if ($pager) {
            include(ROOT_PATH . "/frontend/includes/pager.php");
        }
    }
}


function Frontend_Post_Repost_List($tmp, $count, $pager = false)
{
    global $DBH;

    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE repost_id != 0 ");
    $CHECK->execute();
    $items = $CHECK->fetchColumn();
    if ($items > 0) {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 0;
        }
        $total = (($items - 1) / $count) + 1;
        $total = intval($total);
        // Определяем начало сообщений для текущей страницы
        $page = intval($page);
        // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
        if (empty($page) or $page < 0) $page = 1;
        if ($page > $total) $page = $total;
        // Вычисляем начиная с какого номера следует выводить сообщения
        $start = $page * $count - $count;

        $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code 
		FROM " . DB_PREFIX . "post p 
		INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
		INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
		WHERE p.repost > 0 AND p.repost_id = 0
		ORDER BY u.capital DESC LIMIT $start, $count");
        $RESULT->execute();
        $RESULT->setFetchMode(PDO::FETCH_ASSOC);
    }

    if ($items > 0) {
        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        if ($pager) {
            include(ROOT_PATH . "/frontend/includes/pager.php");
        }
    }
}


function Frontend_Post_Repost_Show_List($id, $count)
{
    global $DBH;

    if (empty($count)) {
        $count = 10;
    }

    $data = array('id' => $id);
    $RESULT = $DBH->prepare("SELECT " . DB_PREFIX . "post.*, " . DB_PREFIX . "user.l_name, " . DB_PREFIX . "user.f_name, " . DB_PREFIX . "country.code AS code, " . DB_PREFIX . "user.image AS user_image   
	FROM " . DB_PREFIX . "post 
	LEFT JOIN " . DB_PREFIX . "user ON " . DB_PREFIX . "user.id = " . DB_PREFIX . "post.user_id
	LEFT JOIN " . DB_PREFIX . "country on " . DB_PREFIX . "country.id = " . DB_PREFIX . "user.country_id 
	WHERE " . DB_PREFIX . "post.repost_id = :id LIMIT $count");
    $RESULT->execute($data);
    $RESULT->setFetchMode(PDO::FETCH_ASSOC);

    include(ROOT_PATH . "/frontend/post/tmp/_repost_list.php");
}


function Frontend_Post_Day($tmp, $count)
{
    global $DBH;

    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post ");
    $CHECK->execute();
    $items = $CHECK->fetchColumn();
    if ($items > 0) {


        $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code 
		FROM " . DB_PREFIX . "post p 
		INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
		INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
		ORDER BY p.view DESC, p.power DESC LIMIT $count");
        $RESULT->execute();
        $RESULT->setFetchMode(PDO::FETCH_ASSOC);
    }
    if ($items > 0) {
        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
    }
}

function Frontend_Post_Repost_Show($id)
{
    global $DBH;

    $data = array('id' => $id);
    $RESULT = $DBH->prepare("SELECT " . DB_PREFIX . "post.*, " . DB_PREFIX . "user.l_name, " . DB_PREFIX . "user.f_name, " . DB_PREFIX . "country.code AS code  
	FROM " . DB_PREFIX . "post 
	LEFT JOIN " . DB_PREFIX . "user ON " . DB_PREFIX . "user.id = " . DB_PREFIX . "post.user_id
	LEFT JOIN " . DB_PREFIX . "country on " . DB_PREFIX . "country.id = " . DB_PREFIX . "user.country_id 
	WHERE " . DB_PREFIX . "post.id = :id ");
    $RESULT->execute($data);
    $RESULT->setFetchMode(PDO::FETCH_ASSOC);
    $row = $RESULT->fetch();

    include(ROOT_PATH . "/frontend/post/tmp/_repost.php");

}


function Frontend_Post_List_inCategory($id, $tmp, $count, $pager = false)
{
    global $DBH;

    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    if (empty($id)) {

        $data = array('category_id' => 0);
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post p
		INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
		WHERE u.category_id != :category_id ");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();

        if ($items > 0) {

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;


            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code  
			FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE u.category_id != :category_id
			ORDER BY p.published DESC LIMIT $start, $count");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }

    } else {
        $data = array('category_id' => $id);
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post p
		INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
		WHERE u.category_id = :category_id ");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();

        if ($items > 0) {

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;



            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code  
			FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE u.category_id = :category_id
			ORDER BY p.published DESC LIMIT $start, $count");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    }

    if ($items > 0) {
        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        if ($pager) {
            include(ROOT_PATH . "/frontend/includes/pager.php");
        }
    }
}


function Frontend_Post_Comment_List($id, $tmp, $count, $pager = false)
{

    global $DBH;

    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    if (empty($id)) {

        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post ");
        $CHECK->execute();
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;


            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			ORDER BY p.comment DESC LIMIT $start, $count");


            $RESULT->execute();
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    } else {
        $data = array('user_id' => $id);

        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE user_id = :user_id ");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;

            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE p.user_id = :user_id
			ORDER BY p.comment DESC LIMIT $start, $count");


            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }

    }

    if ($items > 0) {


        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        if ($pager) {
            include(ROOT_PATH . "/frontend/includes/pager.php");
        }
    }
}

function Frontend_Post_Power_List($id, $tmp, $count, $pager = false)
{
    global $DBH;

    if (empty($count)) {
        $count = 10;
    }
    if (empty($tmp)) {
        $tmp = 'list';
    }

    if (empty($id)) {
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post ");
        $CHECK->execute();
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;

            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			ORDER BY p.power DESC LIMIT $start, $count");
            $RESULT->execute();
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    } else {
        $data = array('user_id' => $id);
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post  WHERE user_id = :user_id");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();
        if ($items > 0) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            $total = (($items - 1) / $count) + 1;
            $total = intval($total);
            // Определяем начало сообщений для текущей страницы
            $page = intval($page);
            // Если значение $page меньше единицы или отрицательно переходим на первую страницу. А если слишком большое, то переходим на последнюю
            if (empty($page) or $page < 0) $page = 1;
            if ($page > $total) $page = $total;
            // Вычисляем начиная с какого номера следует выводить сообщения
            $start = $page * $count - $count;

            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE p.user_id = :user_id
			ORDER BY p.power DESC LIMIT $start, $count");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
        }
    }

    if ($items > 0) {
        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        if ($pager) {
            include(ROOT_PATH . "/frontend/includes/pager.php");
        }
    }
}


function Frontend_Post_Image_Upload()
{

    try {
        // File Route.

        $file = substr(md5(microtime()), 0, 16);
        $folder = substr($file, 0, 2);

        if (!is_dir(ROOT_PATH . POST_UPLOADS . '/' . $folder)) {
            mkdir(ROOT_PATH . POST_UPLOADS . '/' . $folder, 0755);
        }

        $fieldname = "image";

        // Get filename.
        $filename = explode(".", $_FILES[$fieldname]["name"]);

        // Validate uploaded files.
        // Do not use $_FILES["file"]["type"] as it can be easily forged.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        // Get temp file name.
        $tmpName = $_FILES[$fieldname]["tmp_name"];

        // Get mime type.
        $mimeType = finfo_file($finfo, $tmpName);

        // Get extension. You must include fileinfo PHP extension.
        $extension = end($filename);

        // Allowed extensions.
        $allowedExts = array("gif", "jpeg", "jpg", "png", "svg", "blob");

        // Allowed mime types.
        $allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");

        // Validate image.
        if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
            throw new \Exception("File does not meet the validation.");
        }

        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;
        $fullNamePath = ROOT_PATH . POST_UPLOADS . '/' . $folder . '/' . $name;

        // Check server protocol and load resources accordingly.
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }

        // Save file in the uploads folder.
        move_uploaded_file($tmpName, $fullNamePath);

        // Generate response.
        //	$response = new \StdClass;
        //	$response->link = URL_FRONTEND . POST_UPLOADS . '/' . $folder . '/' . $name;


        $response = '{"success" : 1,"file": {"url" : "' . URL_FRONTEND . POST_UPLOADS . '/' . $folder . '/' . $name . '"}}';

        // Send response.
        echo $response;

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}

function Frontend_Post_Add()
{
    global $DBH;

    $warning = '';

    if (isset($_POST['add'])) {

        unset($_POST['add']);

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
        }
        if (isset($_POST['access_id'])) {
            $access_id = $_POST['access_id'];
        }
        if (isset($_POST['price'])) {
            $price = $_POST['price'];
        }
        if (isset($_POST['tag'])) {
            $tag = trim($_POST['tag']);
        }
        if (isset($_POST['repost_id'])) {
            $repost_id = $_POST['repost_id'];
        }

        $user_id = $_SESSION['user']->id;

        $json = json_encode($content['blocks']);

        $cont = '';
        foreach ($content['blocks'] AS $row) {
            if ($row['type'] == 'paragraph') {
                $cont .= '<p>' . $row['data']['text'] . '</p>';
            }
            if ($row['type'] == 'header') {
                $cont .= '<h2>' . $row['data']['text'] . '</h2>';
            }
            if ($row['type'] == 'image') {
                $cont .= '<img src="' . $row['data']['file']['url'] . '" />';
            }

            if ($row['type'] == 'list') {
                $cont .= '<ul>';
                foreach ($row['data']['items'] AS $li) {
                    $cont .= '<li>' . $li . '</li>';
                }
                $cont .= '</ul>';
            }
            if ($row['type'] == 'quote') {
                $cont .= '<blockquote>' . $row['data']['text'] . '</blockquote>';
            }
        }


        if ($name != '') {

            $slug = Translit(trim($name));

            /* Проверка совпадения */
            $data = array('slug' => $slug);
            $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post WHERE slug = :slug");
            $CHECK->execute($data);
            $items = $CHECK->fetchColumn();
            if ($items > 0) {
                $slug = $slug . '-' . time();
            }

            preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $cont, $regexResult);
            $firstImgScr = array_pop($regexResult);

            if (empty($firstImgScr)) {
                $firstImgScr = '';
            }

            $data = array('repost_id' => $repost_id, 'name' => $name, 'content' => $cont, 'json' => $json, 'access_id' => $access_id, 'price' => $price, 'image' => $firstImgScr, 'slug' => $slug, 'user_id' => $user_id, 'published' => date("Y-m-d H:i:s"), 'is_active' => 1);

            $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post ( repost_id, name, content, json, access_id, price, image, slug, user_id, published, is_active) VALUES ( :repost_id, :name, :content, :json, :access_id, :price, :image, :slug, :user_id, :published, :is_active)");
            if ($INSERT->execute($data)) {
                $insert_id = $DBH->lastInsertId();

                /* TAG */
                $data = array('post_id' => $insert_id);
                $DELETE = $DBH->prepare("DELETE FROM " . DB_PREFIX . "post_tag WHERE post_id = :post_id ");
                $DELETE->execute($data);

                $tags = explode(' ', $tag);
                foreach ($tags AS $t) {

                    $data = array('name' => $t);
                    $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "tag WHERE name = :name");
                    $CHECK->execute($data);
                    $items = $CHECK->fetchColumn();
                    if ($items > 0) {

                        $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "tag WHERE name = :name");
                        $RESULT->execute($data);
                        $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                        $row = $RESULT->fetch();

                        $data = array('post_id' => $insert_id, 'tag_id' => $row['id']);
                        $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_tag ( post_id, tag_id) VALUES ( :post_id, :tag_id)");
                        $INSERT->execute($data);

                    } else {

                        $data = array('name' => $t);
                        $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "tag ( name) VALUES ( :name)");

                        if ($INSERT->execute($data)) {
                            $tag_id = $DBH->lastInsertId();

                            $data = array('post_id' => $insert_id, 'tag_id' => $tag_id);
                            $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_tag ( post_id, tag_id) VALUES ( :post_id, :tag_id)");
                            $INSERT->execute($data);

                        }
                    }
                }


                if ($repost_id != 0) {
                    $data = array('id' => $repost_id, 'repost' => 1);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET repost = repost + :repost WHERE id = :id");
                    $UPDATE->execute($data);
                }


                $data = array('user_id' => $user_id);
                $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post WHERE user_id = :user_id ");
                $CHECK->execute($data);

                if ($CHECK->fetchColumn() == 3) {

                    $data = array('id' => $user_id);
                    $RESULT = $DBH->prepare("SELECT agent_id FROM " . DB_PREFIX . "user WHERE id = :id ");
                    $RESULT->execute($data);
                    $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $RESULT->fetch();
                    if ($row['agent_id'] != 0) {
                        $data = array('score' => 100, 'id' => $row['agent_id']);
                        $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score + :score WHERE id = :id");
                        $UPDATE->execute($data);
                    }

                }

                die($slug);
            }
        }
    }
}

function Frontend_Post_Edit($id)
{
    global $DBH;

    $warning = '';

    if (isset($_POST['edit'])) {

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['content'])) {
            $content = $_POST['content'];
        }
        if (isset($_POST['access_id'])) {
            $access_id = $_POST['access_id'];
        }
        if (isset($_POST['price'])) {
            $price = $_POST['price'];
        }
        if (isset($_POST['tag'])) {
            $tag = trim($_POST['tag']);
        }


        $json = json_encode($content['blocks']);


        $cont = '';

        foreach ($content['blocks'] AS $row) {
            if ($row['type'] == 'paragraph') {
                $cont .= '<p>' . $row['data']['text'] . '</p>';
            }
            if ($row['type'] == 'header') {
                $cont .= '<h2>' . $row['data']['text'] . '</h2>';
            }
            if ($row['type'] == 'image') {
                $cont .= '<img src="' . $row['data']['file']['url'] . '" />';
            }

            if ($row['type'] == 'list') {
                $cont .= '<ul>';
                foreach ($row['data']['items'] AS $li) {
                    $cont .= '<li>' . $li . '</li>';
                }
                $cont .= '</ul>';
            }
            if ($row['type'] == 'quote') {
                $cont .= '<blockquote>' . $row['data']['text'] . '</blockquote>';
            }

        }


        preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $cont, $regexResult);
        $firstImgScr = array_pop($regexResult);

        if (empty($firstImgScr)) {
            $firstImgScr = '';
        }

        if (isset($name)) {
            $data = array('name' => $name, 'content' => $cont, 'json' => $json, 'access_id' => $access_id, 'price' => $price, 'image' => $firstImgScr, 'edited' => date("Y-m-d H:i:s"), 'id' => $id);
            $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET name = :name, content = :content, json = :json, access_id = :access_id, price = :price, image = :image, edited = :edited WHERE id = :id");
            $UPDATE->execute($data);


            /* TAG */
            $data = array('post_id' => $id);
            $DELETE = $DBH->prepare("DELETE FROM " . DB_PREFIX . "post_tag WHERE post_id = :post_id ");
            $DELETE->execute($data);

            $tags = explode(' ', $tag);
            foreach ($tags AS $t) {

                $data = array('name' => $t);
                $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "tag WHERE name = :name");
                $CHECK->execute($data);
                $items = $CHECK->fetchColumn();
                if ($items > 0) {

                    $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "tag WHERE name = :name");
                    $RESULT->execute($data);
                    $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $RESULT->fetch();

                    $data = array('post_id' => $id, 'tag_id' => $row['id']);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_tag ( post_id, tag_id) VALUES ( :post_id, :tag_id)");
                    $INSERT->execute($data);

                } else {

                    $data = array('name' => $t);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "tag ( name) VALUES ( :name)");

                    if ($INSERT->execute($data)) {
                        $tag_id = $DBH->lastInsertId();

                        $data = array('post_id' => $id, 'tag_id' => $tag_id);
                        $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_tag ( post_id, tag_id) VALUES ( :post_id, :tag_id)");
                        $INSERT->execute($data);

                    }
                }
            }


            $data = array('id' => $id);
            $RESULT = $DBH->prepare("SELECT slug FROM " . DB_PREFIX . "post WHERE id = :id ");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
            $row = $RESULT->fetch();

            die($row['slug']);
        }
    }
}

function Frontend_Post_Show($id)
{
    global $DBH;

    $data = array('id' => $id);

    $RESULT = $DBH->prepare("SELECT " . DB_PREFIX . "post.*, " . DB_PREFIX . "user.l_name, " . DB_PREFIX . "user.f_name, " . DB_PREFIX . "country.code AS code  
	FROM " . DB_PREFIX . "post 
	LEFT JOIN " . DB_PREFIX . "user ON " . DB_PREFIX . "user.id = " . DB_PREFIX . "post.user_id
	LEFT JOIN " . DB_PREFIX . "country on " . DB_PREFIX . "country.id = " . DB_PREFIX . "user.country_id 
	WHERE " . DB_PREFIX . "post.id = :id ");
    $RESULT->execute($data);
    $RESULT->setFetchMode(PDO::FETCH_ASSOC);
    $row = $RESULT->fetch();

    $RESULT_TAG = $DBH->prepare("SELECT " . DB_PREFIX . "tag.* FROM " . DB_PREFIX . "tag 
	INNER JOIN " . DB_PREFIX . "post_tag ON " . DB_PREFIX . "post_tag.tag_id = " . DB_PREFIX . "tag.id
	WHERE " . DB_PREFIX . "post_tag.post_id = :id");
    $RESULT_TAG->execute($data);
    $RESULT_TAG->setFetchMode(PDO::FETCH_ASSOC);

    $tag_list = '';
    while ($row_tag = $RESULT_TAG->fetch()) {
        $tag_list .= '<a href="/tag?name=' . $row_tag['name'] . '" class="btn btn-outline-danger waves-effect waves-light">#' . $row_tag['name'] . '</a> ';
    }

    /* Проверка просмотров */
    $ip = get_ip();
    $data = array('ip' => $ip, 'post_id' => $id);
    $CHECK = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post_view WHERE ip = :ip AND post_id = :post_id ");
    $CHECK->execute($data);
    $items = $CHECK->fetchColumn();
    if ($items < 1) {

        // Обновляем просмотры поста
        $data = array('id' => $id, 'view' => 1);
        $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET view = view + :view WHERE id = :id");
        $UPDATE->execute($data);

        // Логируем просмотр поста
        $data = array('ip' => $ip, 'post_id' => $id, 'user_id' => $row['user_id'], 'published' => date("Y-m-d H:i:s"));
        $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_view ( ip, post_id, user_id, published) VALUES ( :ip, :post_id, :user_id, :published)");
        $INSERT->execute($data);

        // Выбераем все посты владельца поста за месяц
        $to = date("Y-m-d H:i:s");
        $from = date("Y-m-d H:i:s", strtotime($to . " - 1 month"));

        $between = " AND published BETWEEN ' $from ' AND ' $to ' ";

        $data = array('user_id' => $row['user_id']);
        $RESULT_VIEW = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post_view WHERE user_id = :user_id " . $between);
        $RESULT_VIEW->execute($data);
        $RESULT_VIEW->setFetchMode(PDO::FETCH_ASSOC);

        $view = 0;
        while ($row_view = $RESULT_VIEW->fetch()) {
            $view++;
        }

        $CHECK_VIEW = $DBH->prepare("SELECT COUNT(*) FROM " . DB_PREFIX . "post_view WHERE user_id = :user_id " . $between);
        $CHECK_VIEW->execute($data);
        $items = $CHECK_VIEW->fetchColumn();

        // Обновляем просмотры пользователя
        $capital = ceil($view / $items);

        if ($capital > 0) {
            $data = array('id' => $row['user_id'], 'capital' => $capital);
            $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET capital = :capital WHERE id = :id");
            $UPDATE->execute($data);
        }
    }

    Frontend_Post_Complain();

    include(ROOT_PATH . "/frontend/post/tmp/_show.php");
    $RESULT = null;
}

function Frontend_Post_Power()
{
    global $DBH;

    if (isset($_POST['power'])) {

        if (isset($_SESSION['user'])) {

            if (isset($_POST['id'])) {
                $id = $_POST['id'];
            }
            if (isset($_POST['power'])) {
                $power = $_POST['power'];
            }

            $user_id = $_SESSION['user']->id;

            $data = array('id' => $id);
            $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post WHERE id = :id ");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
            $row = $RESULT->fetch();

            if ($power == 'up') {

                $data = array('post_id' => $id, 'user_id' => $user_id);
                $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post_power WHERE post_id = :post_id AND user_id = :user_id  ");
                $CHECK->execute($data);

                if ($CHECK->fetchColumn() < 1) {

                    $data = array('id' => $id, 'power' => 1);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET power = power + :power WHERE id = :id");
                    $UPDATE->execute($data);

                    $data = array('id' => $row['user_id'], 'power' => 1);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET power = power + :power WHERE id = :id");
                    $UPDATE->execute($data);

                    $data = array('post_id' => $id, 'user_id' => $user_id, 'power' => 1);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_power ( post_id, user_id, power) VALUES ( :post_id, :user_id, :power)");
                    $INSERT->execute($data);

                    echo $row['power'] + 1;
                    die();
                }
            }
            if ($power == 'down') {

                $data = array('post_id' => $id, 'user_id' => $user_id);
                $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post_power WHERE post_id = :post_id AND user_id = :user_id  ");
                $CHECK->execute($data);

                if ($CHECK->fetchColumn() < 1) {

                    $data = array('id' => $id, 'power' => 1);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET power = power - :power WHERE id = :id");
                    $UPDATE->execute($data);

                    $data = array('id' => $row['user_id'], 'power' => 1);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET power = power - :power WHERE id = :id");
                    $UPDATE->execute($data);

                    $data = array('post_id' => $id, 'user_id' => $user_id, 'power' => -1);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_power ( post_id, user_id, power) VALUES ( :post_id, :user_id, :power)");
                    $INSERT->execute($data);

                    echo $row['power'] - 1;
                    die();
                }
            }
        }
        die(false);
    }
}

function Frontend_Post_Promo()
{

    try {
        global $DBH;

        if (isset($_POST['promo']) && isset($_SESSION['user'])) {

            $url_path = parse_url($_POST['slug'], PHP_URL_PATH);
            $uri_parts = explode('/', trim($url_path, ' /')); // Разбиваем виртуальный URL по символу "/"
            $lvl = count($uri_parts) - 1;
            $slug = $uri_parts[$lvl];

            $new_score = $_POST['score'];

            $data = array('slug' => $slug);
            $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE slug = :slug ");
            $CHECK->execute($data);
            $items = $CHECK->fetchColumn();

            if ($items > 0) {
                $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post WHERE slug = :slug ");
                $RESULT->execute($data);
                $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                $row = $RESULT->fetch();

                $user_id = $_SESSION['user']->id;
                $post_id = $row['id'];


                $data = array('is_promo' => 1);
                $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE is_promo = :is_promo ");
                $CHECK->execute($data);
                $items = $CHECK->fetchColumn();

                if ($items > 0) {

                    $RESULT = $DBH->prepare("SELECT * FROM " . DB_PREFIX . "post WHERE is_promo = :is_promo ");
                    $RESULT->execute($data);
                    $RESULT->setFetchMode(PDO::FETCH_ASSOC);
                    $row = $RESULT->fetch();

                    $diff = strtotime($row['promo_to']) - time();
                    $minutes = round($diff / 60);

                    $score = round(($minutes / 60) * $row['score']);

                    // возврат балов
                    $data = array('id' => $row['user_id'], 'score' => $score);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score + :score WHERE id = :id");
                    $UPDATE->execute($data);

                    // снятие поста
                    $data = array('id' => $row['id'], 'is_promo' => 0);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET is_promo = :is_promo WHERE id = :id");
                    $UPDATE->execute($data);


                    // снятие балов
                    $data = array('id' => $user_id, 'score' => $new_score);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score - :score WHERE id = :id");
                    $UPDATE->execute($data);

                    // установка поста
                    $data = array('id' => $post_id, 'is_promo' => 1, 'promo_from' => date("Y-m-d H:i:s"), 'promo_to' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . ' +1 hour ')), 'score' => $new_score);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET is_promo = :is_promo, promo_from = :promo_from, promo_to = :promo_to, score = :score WHERE id = :id");
                    $UPDATE->execute($data);


                    $data = array('user_id' => $user_id, 'post_id' => $post_id, 'published' => date("Y-m-d H:i:s"), 'score' => $new_score);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "user_post_promo ( user_id, post_id, published, score) VALUES ( :user_id, :post_id, :published, :score)");
                    $INSERT->execute($data);

                } else {

                    // снятие балов
                    $data = array('id' => $user_id, 'score' => $new_score);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score - :score WHERE id = :id");
                    $UPDATE->execute($data);

                    // установка поста
                    $data = array('id' => $post_id, 'is_promo' => 1, 'promo_from' => date("Y-m-d H:i:s"), 'promo_to' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . ' +1 hour ')), 'score' => $new_score);
                    $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "post SET is_promo = :is_promo, promo_from = :promo_from, promo_to = :promo_to, score = :score WHERE id = :id");
                    $UPDATE->execute($data);


                    $data = array('user_id' => $user_id, 'post_id' => $post_id, 'published' => date("Y-m-d H:i:s"), 'score' => $new_score);
                    $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "user_post_promo ( user_id, post_id, published, score) VALUES ( :user_id, :post_id, :published, :score)");
                    $INSERT->execute($data);

                }

                Frontend_User_Session_Update($_SESSION['user']->id);

                return true;

            } else {
                return false;
            }

        }

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}


function Frontend_Post_Buy()
{

    try {
        global $DBH;

        if (isset($_POST['buy']) && isset($_SESSION['user'])) {

            $post_id = $_POST['id'];
            $price = $_POST['price'];

            // снятие балов
            $data = array('id' => $_SESSION['user']->id, 'score' => $price);
            $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score - :score WHERE id = :id");
            $UPDATE->execute($data);


            $data = array('user_id' => $_SESSION['user']->id, 'post_id' => $post_id);
            $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "user_post_buy ( user_id, post_id) VALUES ( :user_id, :post_id)");
            $INSERT->execute($data);


            Frontend_User_Session_Update($_SESSION['user']->id);

            return true;

        } else {
            return false;
        }

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}


function Frontend_Post_Donate()
{

    try {
        global $DBH;

        if (isset($_POST['donate']) && isset($_SESSION['user'])) {

            $new_score = $_POST['score'];
            $user_id = $_POST['user_id'];

            // начисление балов
            $data = array('id' => $user_id, 'score' => $new_score);
            $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score + :score WHERE id = :id");
            $UPDATE->execute($data);


            $user_id = $_SESSION['user']->id;
            // снятие балов
            $data = array('id' => $user_id, 'score' => $new_score);
            $UPDATE = $DBH->prepare("UPDATE " . DB_PREFIX . "user SET score = score - :score WHERE id = :id");
            $UPDATE->execute($data);

            Frontend_User_Session_Update($_SESSION['user']->id);
            return true;

        }

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}

function Frontend_Post_Complain()
{

    try {
        global $DBH;

        if (isset($_POST['complain']) && isset($_SESSION['user'])) {

            $post_id = $_POST['post_id'];
            $cause = $_POST['cause'];

            $data = array('user_id' => $_SESSION['user']->id, 'cause' => $cause, 'post_id' => $post_id, 'published' => date("Y-m-d H:i:s"));
            $INSERT = $DBH->prepare("INSERT INTO " . DB_PREFIX . "post_complain ( user_id, post_id, cause, published) VALUES ( :user_id, :post_id, :cause, :published)");
            if ($INSERT->execute($data)) {
                $insert_id = $DBH->lastInsertId();
            }

        }

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}

function Frontend_Post_Promo_Show($tmp)
{

    try {
        global $DBH;


        $data = array('is_promo' => 1);
        $CHECK = $DBH->prepare("SELECT count(*) FROM " . DB_PREFIX . "post WHERE is_promo = :is_promo ");
        $CHECK->execute($data);
        $items = $CHECK->fetchColumn();

        if ($items > 0) {
            $RESULT = $DBH->prepare("SELECT p.*, u.l_name, u.f_name, u.image AS user_image, c.code FROM " . DB_PREFIX . "post p 
			INNER JOIN " . DB_PREFIX . "user u ON u.id = p.user_id 
			INNER JOIN " . DB_PREFIX . "country c ON c.id = u.country_id 
			WHERE p.is_promo = :is_promo ");
            $RESULT->execute($data);
            $RESULT->setFetchMode(PDO::FETCH_ASSOC);
            $row = $RESULT->fetch();
        }

        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        $RESULT = null;

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}


function Frontend_Post_Buy_Show($tmp)
{

    try {
        global $DBH;


        include(ROOT_PATH . "/frontend/post/tmp/" . $tmp . ".php");
        $RESULT = null;

    } catch (Exception $e) {
        // Send error response.
        echo $e->getMessage();
        http_response_code(404);
    }
}

include_once(ROOT_PATH . "/frontend/post/tmp/_sub_functions.php");
