<?php 
/* Роут */
function Route() {
	$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri_parts = explode('/', trim($url_path, ' /')); // Разбиваем виртуальный URL по символу "/"
	$lvl = count($uri_parts)-1;

	$id = $uri_parts[$lvl];
	if($lvl-1 > 0) { $parent = $uri_parts[$lvl-1]; } else { $parent = '';}
	$controller = array_shift($uri_parts); // Получили имя контроллера
	$action = array_shift($uri_parts); // Получили имя действия
	
	if(empty($id)) { $id = 'index'; }
	
	$array = array('id' => $id, 'parent' => $parent, 'action' => $action, 'controller' => $controller  );
	return $array;
}

/* 
function Route() {
	
	$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$uri_parts = explode('/', trim($url_path, ' /')); // Разбиваем виртуальный URL по символу "/"
	$lvl = count($uri_parts)-1;
	
	$id_name = $uri_parts[$lvl];
	$parent_name = $uri_parts[$lvl-1];
	$controller_name = array_shift($uri_parts); // Получили имя контроллера
	$action_name = array_shift($uri_parts); // Получили имя действия
	
  switch ($type) {  
  	case 'id':
  		$slug = $id_name; 
  	break;
		case 'parent':
  		$slug = $parent_name; 
  	break;
  	case 'controller':
  		$slug = $controller_name; 
  	break;
		case 'action':
  		$slug = $action_name; 
  	break;
  }
  return $slug; 
}
Роут */
/* Транслит */
function Translit($str) {
	$tr = array(
		"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d","Е"=>"e","Ё"=>"e","Ж"=>"j",
		"З"=>"z","И"=>"i","Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n","О"=>"o",
		"П"=>"p","Р"=>"r","С"=>"s","Т"=>"t","У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts",
		"Ч"=>"ch","Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"","Э"=>"e","Ю"=>"yu","Я"=>"ya",
		"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j",
		"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n","о"=>"o",
		"п"=>"p","р"=>"r","с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h","ц"=>"ts",
		"ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y","ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
		"A"=>"a","B"=>"b","C"=>"c","D"=>"d","E"=>"e","F"=>"f","G"=>"g","H"=>"h",
		"I"=>"i","J"=>"j","K"=>"k","L"=>"l","M"=>"m","N"=>"n","O"=>"o","P"=>"p",
		"Q"=>"q","R"=>"r","S"=>"s","T"=>"t","U"=>"u","V"=>"v","W"=>"w","X"=>"x","Y"=>"y","Z"=>"z",
		"»"=>"","«"=>"",">"=>"","<"=>"","("=>"",")"=>"","№"=>"","#"=>"","*"=>"","&"=>"",
		" "=>"-","."=>"",","=>"",":"=>"",";"=>"","="=>"-","$"=>"","%"=> "","^"=> "",
		"?"=>"","!"=>"","/"=>"-","|"=>"","'"=>"","_"=>"","+"=>""," - "=>"-","  "=>"-","   "=>"-"
	);
	$str = trim($str);
	return strtr($str,$tr);
}

/* Простая отправка формы */
function SimpleMail($email_to,$email_from,$name_from,$subject,$body) {
	$name_from = "=?UTF-8?B?".base64_encode($name_from)."?=";
	$subject = "=?UTF-8?B?".base64_encode($subject)."?=";

	$headers = "From: $name_from <".$email_from.">\r\n". 
	"MIME-Version: 1.0" . "\r\n" . 
	"Content-type: text/html; charset=UTF-8" . "\r\n"; 

	if(mail($email_to,$subject,$body,$headers)){
		return true;
	}
}

/* Склонение чисел */
function Declension($c, $str1, $str2, $str5, $show_num = true) {
	$c = abs($c) % 100;
	if ($c >= 10 && $c < 80)
		return ($show_num?$c:'').$str5;
	$c %= 10;
	if ($c > 1 && $c < 5)
		return ($show_num?$c:'').$str2;
	if ($c == 1)
		return ($show_num?$c:'').$str1;
		return ($show_num?$c:'').$str5;
}

/* Обрезать строку */
function Truncate( $string, $length ) {
	$string = strip_tags( $string );

	if( mb_strlen( $string ) > $length ){
		$substring = mb_substr( $string, 0, $length );
		if( strrpos( $substring, ' ' ) ){
			return substr( $substring, 0, strrpos($substring, ' ' ) ).'...';
		} else {
			return $substring;
		}
	} else {
		return $string;
	}
}

/* Время назад */
function Time_Ago($date) {
	$diff = time() - strtotime($date);
	$minutes = round( $diff / 60 );
	$hours   = round( $diff / 3600 );
	$days    = round( $diff / 86400 );
	$weeks   = round( $diff / 604800 );
	$months  = round( $diff / 2419200 );
	$years   = round( $diff / 29030400 );
	
	if($diff <= 60) { 
		echo Declension($diff, ' секунду', ' секунды', ' секунд', true);
	} else if($minutes <= 60) { 
		echo Declension($minutes, ' минуту', ' минуты', ' минут', true);
	} else if($hours <= 24) { 
		echo Declension($hours, ' час', ' часа', ' часов', true);
	} else if($days <= 7) { 
		echo Declension($days, ' день', ' дня', ' дней', true);
	} else if($weeks <= 4) { 
		echo Declension($weeks, ' неделю', ' недели', ' недель', true);
	} else if($months <= 12) { 
		echo Declension($months, ' месяц', ' месяца', ' месяцев', true);
	} else { 
		echo Declension($years, ' год', ' года', ' лет', true);
	}
}

/* Возвращает сумму прописью */
function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать','пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка','копейки','копеек',1),
		array('рубль','рубля','рублей',0),
		array('тысяча','тысячи','тысяч',1),
		array('миллион','миллиона','миллионов',0),
		array('миллиард','милиарда','миллиардов',0),
	);

	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/* Склоняем словоформу */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}



/* Сортировка */
function crazysort($comments, $parentComment = 0, $level = 0, $count = null){
	if (is_array($comments) && count($comments)){
		$return = array();
		if (is_null($count)){
			$c = count($comments);
		} else {
			$c = $count;
		}
		for($i=0;$i<$c;$i++){
			if (!isset($comments[$i])) continue;
			$comment = $comments[$i];
			$parentId = $comment['parent_id'];
			if ($parentId == $parentComment){
				$comment['level'] = $level;
				$commentId = $comment['id'];
				$return[] = $comment;
				unset($comments[$i]);
				while ($nextReturn = crazysort($comments, $commentId, $level+1, $c)){
					$return = array_diff ($return, $nextReturn);
				}
			}
		}
		return $return;
	}
	return false;
}

function Sort_Child($rows,$id) {
	foreach ($rows as $row) {
		if(isset($row['parent_id'])) {
			if ($row['parent_id'] == $id) {
				return true;
			}
		} 
	}
	return false;
}

function Sort_Result($rows,$parent=0,$tree=false)
{  
	if($parent==0) {
		if($tree) { $tree = '-tree'; } else { $tree = ''; }
		$result = '<ol class="sortable" id="sortable'.$tree.'">';
	} else {
		$result = '<ol>';
	}
	foreach ($rows as $row)
	{	
		if(isset($row['parent_id'])) {
			if ($row['parent_id'] == $parent) {
				$result.= '<li id="item_'.$row['id'].'"><div>'.$row['name'].'</div>';
				if (Sort_Child($rows,$row['id'])) {
					$result.= Sort_Result($rows,$row['id']);
				}
				$result.= "</li>";
			}
		} else {
			$result.= '<li id="item_'.$row['id'].'"><div>'.$row['name'].'</div></li>';
		}
	}
	$result.= "</ol>";
	return $result;
}


function Sort_Option($rows,$parent=0,$lvl=0,$current=null)
{  
	$result = '';
	$indent = '';
	
	for ($j = 1; $j <= $lvl; $j++) { $indent = $indent.'&nbsp;&nbsp;'; }
	
	foreach ($rows as $row)
	{	
		$selected = '';
		if ($row['id']==$current ) {
			$selected = 'selected="selected"'; 
		}
		if(isset($row['parent_id'])) {
			if ($row['parent_id'] == $parent) {
				$result.= '<option value="'.$row['id'].'" '.$selected.'>'.$indent.$row['name'];
				if (Sort_Child($rows,$row['id'])) {
					$lvl++;
					$result.= Sort_Option($rows,$row['id'],$lvl,$current);
				}
				$result.= "</option>";
			}
		} else {
			$result.= '<option value="'.$row['id'].'" '.$selected.'>'.$indent.$row['name'].'</option>';
		}
	}
	return $result;
}



// Дата
function Date_Ru($date,$declension=false) {
	$date = explode(" ",$date);
	if(is_array($date)) {
		$date_array = explode("-",$date[0]);
	} else {
		$date_array = explode("-",$date);
	}
	$day = '';
	$month = '';
	$year = '';
	if(!empty($date_array[2])) {$day = $date_array[2];}
	if(!empty($date_array[1])) {$month = $date_array[1];}
	if(!empty($date_array[0])) {$year = $date_array[0];}
	
	if($declension) {
		if ($month == "01") { $m = "января"; }
		if ($month == "02") { $m = "февраля"; }
		if ($month == "03") { $m = "марта"; }
		if ($month == "04") { $m = "апреля"; }
		if ($month == "05") { $m = "мая"; }
		if ($month == "06") { $m = "июня"; }
		if ($month == "07") { $m = "июля"; }
		if ($month == "08") { $m = "августа"; }
		if ($month == "09") { $m = "сентября"; }
		if ($month == "10") { $m = "октября"; }
		if ($month == "11") { $m = "ноября"; }
		if ($month == "12") { $m = "декабря"; }
	} else {
		if ($month == "01") { $m = "январь"; }
		if ($month == "02") { $m = "февраль"; }
		if ($month == "03") { $m = "март"; }
		if ($month == "04") { $m = "апрель"; }
		if ($month == "05") { $m = "май"; }
		if ($month == "06") { $m = "июнь"; }
		if ($month == "07") { $m = "июль"; }
		if ($month == "08") { $m = "август"; }
		if ($month == "09") { $m = "сентябрь"; }
		if ($month == "10") { $m = "октябрь"; }
		if ($month == "11") { $m = "ноябрь"; }
		if ($month == "12") { $m = "декабрь"; }
	}
	
	$date = $day.' '.$m.' '.$year;
	
	return $date;
}

// Время
function Time_Ru($date) {
	$date = explode(" ",$date);
	$time_array = explode(":",$date[1]);
	
	$hour = $time_array[0];
	$minut = $time_array[1];
	$second = $time_array[2];
	 
	$time = $hour.':'.$minut;
	
	return $time;
}


function New_Time($a) { // преобразовываем время в нормальный вид
	$ndate = date('d.m.Y', $a);
	$ndate_time = date('H:i', $a);
	$ndate_exp = explode('.', $ndate);
	$nmonth = array(
		1 => 'янв',2 => 'фев',3 => 'мар',4 => 'апр',5 => 'мая',6 => 'июн',7 => 'июл',8 => 'авг',9 => 'сен',10 => 'окт',11 => 'ноя',12 => 'дек'
	);

	foreach ($nmonth as $key => $value) {
		if($key == intval($ndate_exp[1])) $nmonth_name = $value;
	}

	if($ndate == date('d.m.Y')) return 'сегодня в '.$ndate_time;
	elseif($ndate == date('d.m.Y', strtotime('-1 day'))) return 'вчера в '.$ndate_time;
	else return $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2].' в '.$ndate_time;
}

// ID видео с youtube и vimeo
function VideoUrl( $url ) {

	$pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
	$pattern .= '(?:www\.)?';         #  Optional www subdomain.
	$pattern .= '(?:';                #  Group host alternatives:
	$pattern .=   'youtu\.be/';       #    Either youtu.be,
	$pattern .=   '|youtube\.com';    #    or youtube.com
	$pattern .=   '(?:';              #    Group path alternatives:
	$pattern .=     '/embed/';        #      Either /embed/,
	$pattern .=     '|/v/';           #      or /v/,
	$pattern .=     '|/watch\?v=';    #      or /watch?v=,
	$pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
	$pattern .=   ')';                # End path alternatives.
	$pattern .= ')';                  # End host alternatives.
	$pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
	$pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
	preg_match($pattern, $url, $matches);

	$urls = parse_url($url);

	if($urls['host'] == 'vimeo.com'){
		$vid = ltrim($urls['path'],'/');
		$videoArray = array($vid,'vimeo');
		return $videoArray;
	} elseif($urls['host'] == 'vk.com')  {
		$vid = ltrim($urls['path'],'/');
		$videoArray = array($vid,'vk');
		return $videoArray;
	} elseif($urls['host'] != 'vimeo.com')  {
		$urls = $matches[1];
		$videoArray = array($urls,'youtube');
		return $videoArray;
	} else {
		return false;
	}
}

function VideoThumb($video) {
	if ($video[1] == 'youtube') { 
		return "http://img.youtube.com/vi/".$video[0]."/0.jpg";
	} elseif ($video[1] == 'vimeo') { 
		$data = file_get_contents("http://vimeo.com/api/v2/video/".$video[0].".json");
		$data = json_decode($data);
		return $data[0]->thumbnail_medium;
	}
}


function ShareButton( $url,$title,$image,$desc ){
?>
	<div class="shared-button clearfix">
		<a class="vk" href="http://vk.com/share.php?url=<?php echo $url; ?>&title=<?php echo $title; ?>&description=<?php echo $desc; ?>&image=<?php echo $image; ?>&noparse=true" onclick="return Share.me(this);">&nbsp;</a>
		<a class="fb" href="http://www.facebook.com/sharer/sharer.php?s=100&p%5Btitle%5D=<?php echo $title; ?>&p%5Bsummary%5D=<?php echo $desc; ?>&p%5Burl%5D=<?php echo $url; ?>&p%5Bimages%5D%5B0%5D=<?php echo $image; ?>" onclick="return Share.me(this);">&nbsp;</a>
		<a class="tw" href="https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Ffiddle.jshell.net%2F_display%2F&text=<?php echo $title; ?>&url=<?php echo $url; ?>" onclick="return Share.me(this);">&nbsp;</a>
		<?php /*
		<a class="mail" href="http://connect.mail.ru/share?url=<?php echo $url; ?>&title=<?php echo $title; ?>&description=<?php echo $desc; ?>&imageurl=<?php echo $image; ?>" onclick="return Share.me(this);">&nbsp;</a>
		<a class="od" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments=<?php echo $desc; ?>&st._surl=<?php echo $url; ?>" onclick="return Share.me(this);">&nbsp;</a>
		*/ ?>
	</div>
<?php 
}


function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
    } else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


?>