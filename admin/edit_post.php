<?php include "leftbar.php" ?>

<h1>Upravit příspěvek</h1>

<form action="resources/classes/savePost" method="post" id="topicForm">
		<?php

				$id = $request->variable("post", "", true);
				include("../db.php");
				
				function is_valid_post($id){
					include("../db.php");
					$sql = "SELECT id FROM news WHERE id=$id";
				
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$conn->close();
						return true;
					} else {
						$conn->close();
						return false;
					}
					
				}
				
				if(!is_numeric($id)){
					header("Location: https://{DOMENA}.{TLS}");
					die();
				}
				if(!is_valid_post($id)){
					header("Location: https://{DOMENA}.{TLS}");
					die();
				}
				
				function br2nl( $input ) {
					return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n","",str_replace("\r","", htmlspecialchars_decode($input))));
				}
				function cultivate_text($text){
					$text = html_entity_decode($text);
					$text = br2nl($text);
					return $text;
				}
				
				function parse_tags($raw_tag){
					if($raw_tag == "https://{DOMENA}.{TLS}/resources/images/web-tag.svg"){
						return "WEB";
					}
				}
				
				$sql = "SELECT header, author, date, content, id, tag FROM news WHERE id=$id";
				
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {

						$cultivated_text = cultivate_text($row["content"]);
						
						echo '<textarea form="topicForm" name="header" id="headerText" maxlength="100" minlength="5" class="headerText">' . $row["header"] . '</textarea>';
						echo '<textarea form="topicForm" name="content" id="contentText" minlength="80" class="contentText">' . $cultivated_text . '</textarea>';
						echo '<input type="text" name="id" style="display: none" value="' . $id . '">';
					}
				} else {
					header("Location: https://{DOMENA}.{TLS}");
					die();
				}
				$conn->close();
				
			?>
			<input class="button-submit"  type="submit" value="Uložit">
			</form>