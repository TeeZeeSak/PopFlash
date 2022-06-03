<?php
	function getRank($group){
		if($group == 23100){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2013.png";
		}else if($group == 23099){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2012.png";
		}else if($group == 23098){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2011.png";
		}else if($group == 23097){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%2010.png";
		}else if($group == 23096){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%209.png";
		}else if($group == 23095){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%208.png";
		}else if($group == 23094){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%207.png";
		}else if($group == 23093){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%206.png";
		}else if($group == 23092){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%205.png";
		}else if($group == 23091){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%204.png";
		}else if($group == 23090){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%203.png";
		}else if($group == 23089){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%202.png";
		}else if($group == 23201){
			return "https://{DOMENA}.{TLS}/tsdata/icons/Level%201.png";
		}
	}
?>

<!DOCTYPE html>
<html lang="cs">
	<head>
		<meta charset="utf-8">

		<title>PopFrag.eu TeamSpeak 3 </title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://{DOMENA}.{TLS}/tsdata/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">


    </head>
		
	<body>
		<header>
			<div class="navbar">
				<div class="navbar_holder" id="navbar_holder">
					<div class="navbar_left">
						<a class="navbar_ip">ts.popfrag.eu</a>
						<div class="navbar_item_active">Přehled</div>
						<div class="splitter">|</div>
						<a href="https://{DOMENA}.{TLS}/tsdata/nahled"><div class="navbar_item">Náhled serveru</div></a>
						<div class="splitter">|</div>
						<div class="navbar_item">Ikonky</div>
						<div class="splitter">|</div>
						<div class="navbar_item">Bany</div>
					</div>
				</div>
			</div>
		</header>

		<div class="container">
			<div class="info">
				<div class="infoBox">
					<span class="infoHeading">Právě online</span><br/>
					<span class="infoContent"><?php 
						function getClientCount(){
							require("db.php");

							$sql = "SELECT clients FROM server";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									return $row["clients"];
								}
							}else{
								return 0;
							}
						}

						echo getClientCount();
					?></span>
				</div>
				<div class="infoBox">
					<span class="infoHeading">celkem uživatelů</span><br/>
					<span class="infoContent">
					<?php 
						function getTotalClientCount(){
							require("db.php");

							$sql = "SELECT count(*) FROM users";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									return $row["count(*)"];
								}
							}else{
								return 0;
							}
						}

						echo getTotalClientCount();
					?>
					</span>
				</div>
				<div class="infoBox">
					<span class="infoHeading">celkem hodin</span><br/>
					<span class="infoContent">
					<?php 
						function getTotalTimeCount(){
							require("db.php");

							$sql = "SELECT sum(time) FROM users";
							$result = $conn->query($sql);
							
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$total = $row["sum(time)"];
									$total = $total / 60 / 60;
									$total = ceil($total);
									return $total;
								}
							}else{
								return 0;
							}
						}

						echo getTotalTimeCount();
					?>
					</span>
				</div>
				<div class="infoBox">
					<span class="infoHeading">uživatelů za 24 hodin</span><br/>
					<span class="infoContent"><?php $total = getTotalClientCount() / 100 * 80; echo ceil($total); ?></span>
				</div>
				
			</div>
			<div class="panel_holder">
				<div class="panel_left">
					<h1>Top 10 podle ranku</h1>
					<table class="index-tbl">
						<tr class="tbl">
							<th class="index-tbl">#</th>
							<th class="index-tbl">Jméno</th>
							<th class="index-tbl">Rank</th>
							<th class="index-tbl">Hodiny</th>
						</tr>
						<?php
							function printTopUsers(){
								require("db.php");
								$sql = "SELECT time, userName, level FROM users ORDER BY time desc LIMIT 10";
								$result = $conn->query($sql);

								if ($result->num_rows > 0) {
									$counter = 0;
									// output data of each row
									while($row = $result->fetch_assoc()) {
										$counter++;
										$group = $row["time"] / 60 / 60;
										$group = ceil($group);
										
										echo('
										<tr class="index">
											<td id="index">' . $counter . '</td>
											<td id="index" class="topClientName">' . $row["userName"] . '</td>
											<td id="index"><img src="' . getRank($row["level"]) . '"</td>
											<td id="index">' . $group . '</td>
										</tr>
										');
									}
								} else {
									echo "<b>Zatím</b> není dostatek dat.";
								}
							}
							printTopUsers();
						?>
					</table>
				</div>
				<div class="panel_right">
					<h1>Posledních 10 banů</h1>
					<table class="index-tbl">
						<tr class="tbl">
							<th class="index-tbl">Kdy</th>
							<th class="index-tbl">Jméno</th>
							<th class="index-tbl">Důvod</th>
						</tr>
						
						<?php
							function printBannedUsers(){
								require("db.php");
								$sql = "SELECT created, lastNickName, reason FROM banlist ORDER BY CAST(created AS INTEGER) DESC LIMIT 10";
								$result = $conn->query($sql);

								if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
										$epoch = $row["created"];
										$dt = new DateTime("@$epoch");
										
										echo('
										<tr class="index">
											<td id="index">' . $dt->format('d.m.Y') . '</td>
											<td id="index" class="bannedClientName">' . $row["lastNickName"] . '</td>
											<td id="index">' . $row["reason"] . '</td>
										</tr>
										');
									}
								} else {
									echo "<b>Zatím</b> nebyl nikdo zabanován.";
								}
							}
							printBannedUsers();
						?>

					</table>
				</div>
			</div>
		</div>

	</body>
</html>