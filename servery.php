
<!DOCTYPE html>
<html lang="cs">
	<head>
		<link rel="stylesheet" type="text/css" href="/style/main.css?<?php echo rand(0,10000000); ?>">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400&display=swap" rel="stylesheet">
		<script src="https://kit.fontawesome.com/a00bceb363.js?  crossorigin="anonymous"></script>
		<script src="resources/js/interactive.js?<?php echo rand(0,10000000); ?>"></script>
		<title>PopFrag.eu</title>
		<?php include("meta.php"); ?>
	</head>

	<body>
		<?php
			include("header.php");
			include("db.php");
		?>
		
		
		<div class="servers-holder">

			<div class="servers">
			<h2 id="serversheader">CS:GO servery</h1>
				<div class="server">
					<div class="type" id="csgo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div class="name">Sniperwar</div>
					<div class="ip">217.11.249.84:27900</div>
					<div class="players"><?php $sniperwar = 'http://query.fakaheda.eu/217.11.249.84:27900.feed';
					$sniperwar_data = json_decode(file_get_contents($sniperwar), true);
					echo $sniperwar_data['players'] . '/' . $sniperwar_data['slots'];?></div>
					<div class="map"><?php echo $sniperwar_data['map']?></div>
					<div class="actions">
						<a class="vip">VIP</a>
						<a href="http://hlstats.fakaheda.eu/hlxce_306909/hlstats.php" class="statistics">Statistiky</a>
						<a href="http://sourcebans.fakaheda.eu/sbans_308319/index.php?p=banlist" class="banlist">Banlist</a>
					</div>
				</div>
				<div class="server">
					<div class="type" id="csgo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div class="name">1v1 Aréna #1</div>
					<div class="ip">217.11.249.83:27518</div>
					<div class="players"><?php $arenyI = 'http://query.fakaheda.eu/217.11.249.83:27518.feed';
					$arenyI_data = json_decode(file_get_contents($arenyI), true);
					echo $arenyI_data['players'] . '/' . $arenyI_data['slots'];?></div>
					<div class="map"><?php echo $arenyI_data['map']?></div>
					<div class="actions">
						<a class="vip">VIP</a>
						<a href="http://hlstats.fakaheda.eu/hlxce_306909/hlstats.php" class="statistics">Statistiky</a>
						<a href="http://sourcebans.fakaheda.eu/sbans_308319/index.php?p=banlist" class="banlist">Banlist</a>
					</div>
				</div>
				<hr class="servers-spacer">

				<h2 id="serversheader">Voice servery</h1>
				<div class="server">
					<div class="type" id="ts3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div class="name">Team Speak 3</div>
					<div class="ip">ts.popfrag.eu</div>
					<div class="players"><?php $url = 'http://query.fakaheda.eu/82.208.17.98:6376.feed';
					$obj = json_decode(file_get_contents($url), true);
					echo $obj['players'] . '/' . $obj['slots'];?></div>
					<div class="map"></div>
					<div class="actions">
						<a class="vip">VIP</a>
						<a href="https://{DOMENA}.{TLS}/tsdata/" class="statistics">Statistiky</a>
						<a class="banlist">Banlist</a>
					</div>
				</div>
				
			</div>
			<hr class="servers-spacer">
			
		</div>


				<?php
		include "footer.html";
		?>
		
	</body>
</html>