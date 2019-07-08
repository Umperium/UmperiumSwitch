<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/config.php");
include_once ($_SERVER['DOCUMENT_ROOT']."/backend/lock.php");

function Backend_Country_Route() {
	try{
		$title = "Страны";
		
		if(isset($_GET['action'])) { 
			$action = $_GET['action']; 
			if(isset($_GET['id'])) { $id = (int)$_GET['id'];}

			switch ($action) {
				case 'add':	
					$name = "Добавить";
					$breadcrumbs = '<a href="/backend/country">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/country/tmp/showSuccess.php");
					return false;
				break;
				case 'edit':
					$name = "Редактировать";
					$breadcrumbs = '<a href="/backend/country">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/country/tmp/showSuccess.php");
					return false;
				break;
				case 'sort':
					$name = "Сортировать";
					$breadcrumbs = '<a href="/backend/country">'.$title.'</a> &rsaquo; <a href="">'.$name.'</a>';

					require_once(ROOT_PATH."/backend/country/tmp/showSuccess.php");
					return false;
				break;
				case 'delete':
					Backend_Country_Delete($id);
					return false;
				break;
				case 'is_active':	
					Backend_Country_Active($id);
					return false;
				break;
			}
		} else { 
			$name = "";
			$breadcrumbs = '<a href="/backend/country">'.$title.'</a>';

			require_once(ROOT_PATH."/backend/country/tmp/showSuccess.php");
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
function Backend_Country_List() {
	global $DBH;
	
	try{
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."country");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."country ORDER BY sort ASC");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);

			require_once(ROOT_PATH."/backend/country/tmp/_list.php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Сортировка */
function Backend_Country_Sort() {
	global $DBH;
	
	try{
		
		if( isset( $_GET['item'] ) && is_array( $_GET['item'] ) ) {
			$i=0;
			foreach( $_GET['item'] as $item => $parent_id ) {
				$data = array( 'id' => intval($item), 'sort' => $i++ ); 
				$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."country SET sort = :sort WHERE id = :id");
				$UPDATE->execute($data);
			}
		}
		
		$CHECK = $DBH->prepare("SELECT COUNT(*) FROM ".DB_PREFIX."country");
		$CHECK->execute();
		$items = $CHECK->fetchColumn();

		if ($items > 0) {
			$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."country ORDER BY sort ASC");
			$RESULT->execute();
			$RESULT->setFetchMode(PDO::FETCH_ASSOC);
			
			$result = array();
			while($row = $RESULT->fetch()) {
				$result[] = array('id' => $row['id'], 'name' => $row['name'], 'sort' => $row['sort'] );
			}
			
			require_once(ROOT_PATH."/backend/country/tmp/_sort.php");
			return false;
		}
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Добавление */
function Backend_Country_Add() {
	global $DBH;
	
	try{
		$warning = '';
		
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_add']))   { $save = 2; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {
			
			if(isset($_POST['name']))			{ $name = $_POST['name']; }
			if(isset($_POST['code']))			{ $code = $_POST['code']; }
			
			$data = array( 'name' => $name, 'code' => $code,);
			
			$INSERT = $DBH->prepare("INSERT INTO ".DB_PREFIX."country ( name, code ) VALUES ( :name, :code )");

			if($INSERT->execute($data)) {
				$insert_id = $DBH->lastInsertId();
				
				$warning = 'Запись сохранена';
				
				switch ($save) {
					case 1:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/country?action=edit&id=".$insert_id."'></head></html>";
						return false;
					break;
					case 2:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/country?action=add'></head></html>";
						return false;
					break;
					case 3:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/country'></head></html>";
						return false;
					break;
				}
			}
		}

		require_once(ROOT_PATH."/backend/country/tmp/_add.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Редактирование */
function Backend_Country_Edit($id) {
	global $DBH;
	
	try{
		$warning = '';
		
		// Тип сохранения
		if(isset($_POST['save']))       { $save = 1; }
		if(isset($_POST['save_add']))   { $save = 2; }
		if(isset($_POST['save_back']))  { $save = 3; }

		if(!empty($save)) {
			
			if(isset($_POST['name']))			{ $name = $_POST['name']; }
			if(isset($_POST['code']))			{ $code = $_POST['code']; }
			
			$data = array( 'name' => $name, 'code' => $code, 'id' => $id);
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."country SET name = :name, code = :code WHERE id = :id");

			if($UPDATE->execute($data)) {	
				$UPDATE = null;
				
				$warning = 'Запись обновлена';

				switch ($save) {
					case 2:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/country?action=add'></head></html>";
					break;
					case 3:
						echo "<html><head><meta http-equiv='Refresh' content='0;URL=/backend/country'></head></html>";
					break;
				}
			}
		}

		$data = array( 'id' => $id); 
		$RESULT = $DBH->prepare("SELECT * FROM ".DB_PREFIX."country WHERE id = :id ");
		$RESULT->execute($data);
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);
		$row = $RESULT->fetch();

		require_once(ROOT_PATH."/backend/country/tmp/_edit.php");
		return false;
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Удаление */
function Backend_Country_Delete($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		$DELETE = $DBH->prepare("DELETE FROM ".DB_PREFIX."country WHERE id = :id ");
		$DELETE->execute($data);
		
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/country"); 
		exit();
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

/* Активирование */
function Backend_Country_Active($id) {
	global $DBH;
	
	try{
		$data = array( 'id' => $id ); 
		
		$RESULT = $DBH->prepare("SELECT is_active FROM ".DB_PREFIX."country WHERE id = :id");
		$RESULT->setFetchMode(PDO::FETCH_ASSOC);   
		$RESULT->execute($data);
		$row = $RESULT->fetch();
		
		if ($row['is_active'] == 1) {
			$data = array( 'id' => $id, 'is_active' => 0 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."country SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		
		if ($row['is_active'] == 0) {
			$data = array( 'id' => $id, 'is_active' => 1 ); 
			$UPDATE = $DBH->prepare("UPDATE ".DB_PREFIX."country SET is_active = :is_active WHERE id = :id");  
			$UPDATE->execute($data);
			$UPDATE = null;
		}
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: /backend/country"); 
		exit();
		
	} catch(PDOException $e){
		echo $e->getMessage();
	}
}

Backend_Country_Route();
?>