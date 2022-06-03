<h1>Nový příspěvek</h1>

<form action="resources/classes/newPost" method="post" id="topicForm">
	Tag: <select name="tag">
		<option value="csgo">CS: GO</option>
		<option value="web">Web</option>
	</select>
	<textarea maxlength="80" required form="topicForm" minlength="5" class="headerText" name="header" placeholder="Název příspěvku"></textarea><br />
	<textarea form="topicForm" required id="contentText" minlength="100" name="content" class="contentText" placeholder="Text příspěvku"></textarea><br />

	<input class="button-submit"  type="submit" value="Uložit">
</form>