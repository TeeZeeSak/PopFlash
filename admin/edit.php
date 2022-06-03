
<?php
	function is_admin($id){
		$servername = "host";
		$username = "username";
		$password = "password";
		$dbname = "forum";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

				
		
		$sql = "SELECT blog_auth_level FROM phpbb_users WHERE user_id=$id";
				
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if($row["blog_auth_level"] == "1"){
					return true;
				}
			}
		}
		$conn->close();
		return false;
	}


	define('IN_PHPBB', true);
	define('ROOT_PATH', "../forum");

	if (!defined('IN_PHPBB') || !defined('ROOT_PATH')) {
		exit();
	}

	$phpEx = "php";
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : ROOT_PATH . '/';
	include($phpbb_root_path . 'common.' . $phpEx);

	$user->session_begin();
	$auth->acl($user->data);
	
	$user_id = $user->data["user_id"];
	if(!is_admin($user_id)){
		header("Location: https://{DOMENA}.{TLS}/forum/ucp.php?mode=login");
		die();
	}	
?>
	


<head>
	<link rel="stylesheet" type="text/css" href="style/main.css?<?php echo rand(0,10000000); ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a00bceb363.js?  crossorigin="anonymous"></script>
	<script src="resources/js/interactive.js?<?php echo rand(0,10000000); ?>"></script>
	<title>PopFrag.eu - Příspěvky</title>
</head>

<body>

	<?php include "leftbar.php" ?>
	<div class="content-holder">
		<?php
			$gSucc = $request->variable("s", "", true);
			
			if($gSucc == "1"){
				echo '<div class="success"><p class="success-info-text">Úspěch! Příspěvek byl úspěšně upraven.</p></div>';
			}
			if($gSucc == "2"){
				echo '<div class="success"><p class="success-info-text">Úspěch! Příspěvek byl úspěšně smazán.</p></div>';
			}
		?>
		<h1 class="topicHeading">Příspěvky</h1><a href="https://{DOMENA}.{TLS}/admin/post.php?action=new"><button class="quickAddNew">Přidat</button></a></br></br>
		
		<table class="editTopicsTable">
			<tr class="editTopicsRow">
				<th>&nbsp;Nadpis</th>
				<th>Autor</th>
				<th>Kategorie</th>
				<th>Publikováno</th>
				<th>Akce</th>
			</tr>
			<?php
				include("../db.php");
				
				function parse_tags($raw_tag){
					if($raw_tag == "https://{DOMENA}.{TLS}/resources/images/web-tag.svg"){
						return "WEB";
					}
					if($raw_tag == "https://{DOMENA}.{TLS}/resources/images/csgo_tag.svg"){
						return "CS:GO";
					}
				}
				
				$sql = "SELECT header, author, date, id, tag FROM news";
				
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						echo '
						<tr>
							<td>&nbsp;<a href="https://{DOMENA}.{TLS}/admin/post.php?post=' . $row["id"] . '&action=edit" class="tableHeader">' . $row["header"] . '</a></td>
							<td>' . $row["author"] . '</td>
							<td>' . parse_tags($row["tag"]) . '</td>
							<td>' . $row["date"] . '</td>
							<td><a href="https://{DOMENA}.{TLS}/admin/post.php?action=delete&post=' . $row["id"] . '"<i id="icon-red" class="fas fa-trash"></i></a></td>
							
						</tr>
						';
					}
				} else {
					echo "Zatím nebyly publikovány žádné novinky";
				}
				$conn->close();
			?>
			<tr class="editTopicsRow">
					<th>&nbsp;Nadpis</th>
					<th>Autor</th>
					<th>Kategorie</th>
					<th>Publikováno</th>
					<th>Akce</th>
			</tr>
		</table>
	</div>
</body>