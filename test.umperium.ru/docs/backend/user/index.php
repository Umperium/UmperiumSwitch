<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/backend/lock.php");

function Backend_User_Route() {
	try{
		$title = "Пользователи";
		
		if(isset($_GET['action'])) { 
			$action = $_GET['action']; 
			if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

			switch ($action) {
				case 'add':
					$name = "Добавить";
					$breadcrumbs = '<a href="/backend/user">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/user/tmp/showSuccess.php");
					return false;
				break;
				case 'edit':
					$name = "Редактировать";
					$breadcrumbs = '<a href="/backend/user">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/user/tmp/showSuccess.php");
					return false;
				break;
				case 'delete':
					Backend_User_Delete($id);
					return false;
				break;
				case 'is_active':
					Backend_User_Active($id);
					return false;
				break;
				case 'ajax_list':
					Backend_User_List_Ajax();
					return false;
				break;
			}
		} else { 
			$name = "";
			$breadcrumbs = '<a href="/backend/user">'.$title.'</a>';

			require_once(ROOT_PATH."/backend/user/tmp/showSuccess.php");
			return false;
		}
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /404"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Список */
function Backend_User_List($tmp) {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user ORDER BY published DESC");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/backend/user/tmp/".$tmp.".php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Список */
function Backend_User_List_Ajax() {
	global $DBH;
	
	try{
		
		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		$colIndex = $_POST['order'][0]['column']; // Column index
		$colName = $_POST['columns'][$colIndex]['data']; // Column name
		$colSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = $_POST['search']['value']; // Search value

		// Search 
		$searchQuery = " ";
		if($searchValue != ''){
			$searchQuery = " AND ( ".DB_PREFIX."user.l_name like '%".$searchValue."%' OR ".DB_PREFIX."user.f_name like '%".$searchValue."%' OR ".DB_PREFIX."user.email like '%".$searchValue."%' OR ".DB_PREFIX."country.name like '%".$searchValue."%' OR ".DB_PREFIX."user.city like '%".$searchValue."%' ) ";
		}

		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user " );
		$CHECK->execute();
		$totalRecords = $CHECK->fetchColumn();	

		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."user 
		LEFT JOIN ".DB_PREFIX."country ON ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id
		WHERE 1 ".$searchQuery);
		$CHECK->execute();
		$totalRecordwithFilter = $CHECK->fetchColumn();
		
		if($totalRecordwithFilter > 0) {
		
			$RESULT = $DBH->prepare("SELECT ".DB_PREFIX."user.*, ".DB_PREFIX."country.name AS country FROM ".DB_PREFIX."user 
			LEFT JOIN ".DB_PREFIX."country ON ".DB_PREFIX."country.id = ".DB_PREFIX."user.country_id
			WHERE 1 ".$searchQuery." ORDER BY ".$colName." ".$colSortOrder." LIMIT ".$row.",".$rowperpage." ");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			while($row = $RESULT->fetch()) {


				if($row['is_active']==1) { $is_active ='active'; }
				if($row['is_active']==0) { $is_active ='no-active'; }
				
				if($row['sex']=='male') { $sex ='Мужской'; }
				if($row['sex']=='female') { $sex ='Женский'; }

				$data[] = array(
					"id"=>$row['id'],
					"name"=>'<a title="Редактировать" href="?id='.$row['id'].'&action=edit">'.$row['l_name'].' '.$row['f_name'].'</a>',
					"email"=>'<a title="Редактировать" href="?id='.$row['id'].'&action=edit">'.$row['email'].'</a>',
					"country"=>'<a title="Редактировать" href="?id='.$row['id'].'&action=edit">'.$row['country'].'</a>',
					"city"=>$row['city'],
					"sex"=>$sex,
					"score"=>$row['score'],
					"action"=>'
						<div class="'.$is_active.'">
						<a href="?action=is_active&id='.$row['id'].'" class="status"><i class="fa fa-check-square"></i></a>
						<a href="?action=delete&id='.$row['id'].'" class="delete" title="Удалить?"><i class="fa fa-trash-alt"></i></a>
						</div>
					'
				);
			}

			## Response
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordwithFilter,
				"aaData" => $data
			);
		
		} else {
			$response = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => 0,
				"aaData" => array()
			);
		}
		
		echo json_encode($response);
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}


/* Редактирование */
function Backend_User_Edit($id) {
	global $DBH;
	
	try{
		$warning = '';
		
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_add']))   { $save = 2; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {
			
			if(isset($_POST['l_name']))			{ $l_name = $_POST['l_name']; }
			if(isset($_POST['f_name']))			{ $f_name = $_POST['f_name']; }
			
			if(isset($_POST['sex']))			{ $sex = $_POST['sex']; }
			if(isset($_POST['city']))			{ $city = $_POST['city']; }
			if(isset($_POST['score']))			{ $score = $_POST['score']; }
			if(isset($_POST['category_id']))	{ $category_id = $_POST['category_id']; }
			
			if(isset($_POST['is_vip']))		{
				$is_vip = $_POST['is_vip'];
				if(isset($_POST['category_id']))	{ $category_id = $_POST['category_id']; }
			} else { 
				$is_vip = 0;
				$category_id = 0;
			}
			
			$data = array( 'l_name' => $l_name, 'f_name' => $f_name, 'sex' => $sex, 'city' => $city, 'score' => $score, 'category_id' => $category_id, 'is_vip' => $is_vip, 'id' => $id);

			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET l_name = :l_name, f_name = :f_name, sex = :sex, city = :city, score = :score, category_id = :category_id, is_vip = :is_vip WHERE id = :id");

			if($UPDATE->execute($data)) {	
				$UPDATE = null;
				
				$warning = 'Запись обновлена';
				
				switch ($save) {
					case 2:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/user?action=add'></head></html>";
						return false;
					break;
					case 3:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/user'></head></html>";
						return false;
					break;
				}
			}
		}

		$data = array( 'id' => $id); 
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."user WHERE id = :id ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();
		
		require_once(ROOT_PATH."/backend/user/tmp/_edit.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Удаление */
function Backend_User_Delete($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."user WHERE id = :id ");
		$DELETE->execute($data);
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/user"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}



/* Активирование */
function Backend_User_Active($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		
		$RESULT = $DBH->prepare("SELECT is_active FROM ".DB_PREFIX."user WHERE id = :id");
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);   
		$RESULT->execute($data);
		$row = $RESULT->fetch();
		
		if ($row['is_active'] == 1) {
			$data = array( 'id' => $id, 'is_active' => 0 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		
		if ($row['is_active'] == 0) {
			$data = array( 'id' => $id, 'is_active' => 1 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."user SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/user"); 
		exit();
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

Backend_User_Route();
?>