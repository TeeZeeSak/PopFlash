
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
		
		
		<div class="news-holder">
			<?php
				
				
				$sql = "SELECT id, link, date, header, content, tag, author FROM news ORDER BY id DESC LIMIT 10";
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
				include "sidebar.html";
				?>
			</div>
		</div>

		<?php
		include "footer.html";
		?>
		
	</body>
</html>