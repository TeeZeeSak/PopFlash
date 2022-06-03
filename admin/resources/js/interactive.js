


document.addEventListener("DOMContentLoaded", function(event) {
	if(document.getElementById('savePost') != null)
    document.getElementById('savePost').onclick = savePost;
	if(document.getElementById('iconYes') != null)
	document.getElementById('iconYes').onclick = iconYes;
	
});
 
 
function iconYes(){
	const urlParams = new URLSearchParams(window.location.search);
	const post = urlParams.get('post');
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		if(this.responseText.includes("success")){
			window.location.href = "https://{DOMENA}.{TLS}/admin/edit.php?s=2";
		}else{
			console.log(this.responseText);
		}
	  }
	};
	xhttp.open("GET", "https://{DOMENA}.{TLS}/admin/resources/classes/deletePost?post=" + post, true);
	xhttp.send();
}
 
function savePost(){

	let headerText = document.getElementById("headerText").innerHTML;
	let contentText = document.getElementById("contentText").innerHTML;
	alert(headerText);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let result = this.responseText;
			alert(result);
			/*if(result == "success"){
				window.location.href = "https://{DOMENA}.{TLS}/admin/edit.php";
			}*/
		}
	};
	xhttp.open("POST", "https://{DOMENA}.{TLS}/admin/resources/classes/savePost.php", true); 
	xhttp.send("header=" + headerText + "&contentText=" + contentText); 
}

