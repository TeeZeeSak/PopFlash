<head>
	<link rel="stylesheet" type="text/css" href="/style/main.css?<?php echo rand(0,10000000); ?>">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a00bceb363.js?  crossorigin="anonymous"></script>
	<script src="https://{DOMENA}.{TLS}/resources/js/interactive.js?<?php echo rand(0,10000000); ?>"></script>
	<title>PopFrag.eu</title>
	<?php
include "../meta.php";
	?>
</head>

<body>
	<?php
		include("../db.php");
	?>
	

		<div class="header-image"/>


		<div class="header">
		<div id="l3" class="popfrag-user-menu">
					<?php
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
					if($user->data["is_registered"]){
						$authlevel = null;
						$userid = $user->data["user_id"];
						$servername = "host";
						$username = "username";
						$password = "password";
						$dbname = "forum";

						// Create connection
						$forumcc = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($forumcc->connect_error) {
							die("Connection failed: " . $forumcc->connect_error);
						}
						$sql_authlevel = "SELECT blog_auth_level FROM phpbb_users WHERE user_id=$userid";
						
						$result = $forumcc->query($sql_authlevel);
						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								$authlevel = $row["blog_auth_level"];
							}
						}
						
						if($authlevel > 0){
							echo '<a class="panel-admin" href="https://{DOMENA}.{TLS}/admin"><font color="red">Administrace</font></a>';
						}
						echo '
						<div onClick="toggleDropDownContent()" class="dropdown">
							<button onclick="toggleDropDownContent()" class="dropbtn"><a onclick="toggleDropDownContent()" style="cursor: pointer !important; color: #' . $user->data["user_colour"] . '">' .$user->data["username"] . '</a>
							  <i onclick="toggleDropDownContent()" style="color: orange;	cursor: pointer !important;" class="fa fa-caret-down"></i>
							</button>
							<div class="dropdown-content">
							  <a href="https://{DOMENA}.{TLS}/forum/ucp.php"><i class="fas fa-portrait"></i> Uživatelský panel</a>
							  <a href="https://{DOMENA}.{TLS}/forum/memberlist.php?mode=viewprofile&u=' . $user->data["user_id"] . '"><i class="fas fa-user"></i> Profil</a>
							  <a href="https://{DOMENA}.{TLS}/forum/ucp.php?mode=logout&sid=' . $user->data["session_id"] . '"><i class="fas fa-power-off"></i> Odhlásit se</a>
							</div>
						</div>';
						
					}
					?>
		</div>
		<div class="head-section" id="head-event">
			<!--<pseudo onclick="window.location.href = 'https://popfrag.eu'"><span class="logo"><a id="l1" class="logo-pop">POP</a><a id="l2" class="logo-frag">FRAG</a></span></pseudo>-->
			<div class="menu-items-holder">
				<ul id="navigation">
					<li><a href="https://{DOMENA}.{TLS}/" id="blog" class="head-section-item">BLOG</a></li>
					<li><a href="https://{DOMENA}.{TLS}/forum" id="forum" class="head-section-item">FÓRUM</a></li>
					<li><a href="https://{DOMENA}.{TLS}/servery" id="servery" class="head-section-item">SERVERY</a></li>
					<li><a href="https://{DOMENA}.{TLS}/kontakt" id="kontakt" class="head-section-item">KONTAKT</a></li>
				</a>
			</div>
			
		</div>
		<?php
			if(!$user->data['is_registered']){
				echo('
				<div class="login-panel">
					<div class="login-vars"><p class="login-form"><a class="login-panel-register" href="https://{DOMENA}.{TLS}/forum/ucp.php?mode=register">Registruj se</a> zdarma nebo <input id="txtUser" class="login-form" type="text" placeholder="Login"/> <input id="txtPass" class="login-form" type="password" placeholder="Heslo"/> <input id="btnLogin" class="login-form-button" value="Přihlásit se" type="button"></div></p>
					<div id="loginFail" class="login-failure"><p id="failureText" class="login-failure">Neplatné přihlašovací údaje. Zapomenuté heslo? Resetuj si heslo <a class="login-panel-register" href="https://{DOMENA}.{TLS}/forum/ucp.php?mode=sendpassword">zde</a></div></p>

				</div>
				');
			}
		?>

		</div>

		<div class="news-holder">
					<?php
					if($request->variable("succ", "", true) == "1"){
						echo '<div class="boxSuccess"><p class="success-info-text">Úspěch! Příspěvek byl úspěšně vytvořen!</p></div>';
					}

						include "../db.php";
						$link = $request->server("SERVER_NAME", "");
						$link .= parse_url($request->server("REQUEST_URI", ""), PHP_URL_PATH);
						$sql = "SELECT id, link, date, header, content, tag, author FROM news WHERE link='https://$link'";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								echo '
								<div class="content">
								
									<div class="news-content">
										<div class="news-spacionator">
											<a href="' . $row["link"] . '"><p class="news-header">' . $row["header"] . '</p></a>
											<p class="news-date">' . $row["date"] . ' - <img class="news-tag" src="' . $row["tag"] . '" width="36px" height="24px"/></p>
											<p class="news-intro">' . html_entity_decode($row["content"]) . '</p>
											<a href="http://www.facebook.com/sharer.php?u=' . $row["link"] . '&t=' . $row["header"] . '"><img src="https://{DOMENA}.{TLS}/resources/images/fb_like.svg" alt="Sdílej na Facebooku"/></a>
										</div>
									</div>
								</div>
								<hr class="news-spacer">
								';
							}
						} else {
							echo "Zatím nebyly publikovány žádné novinky";
						}
						$conn->close();
					?>
					<div class="sidebar">
						<?php
							include "../sidebar.html";
						?>
					</div>
					
		</div>
				<?php
		include "../footer.html";
		?>

</body>