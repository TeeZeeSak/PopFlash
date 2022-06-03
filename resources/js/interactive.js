let dropDownVisible = false;





window.onscroll = function(ev) {
	/*let section = document.getElementById("head-event");
	let l1 = document.getElementById("l1");
	let l2 = document.getElementById("l2");
	let l3 = document.getElementById("l3");
	let mItem = document.getElementsByClassName("head-section-item");
	//console.log(window.scrollY);
    if (window.scrollY > 1) {
        section.style.backgroundColor = "#212121";
		l1.style.color = "white";
		l2.style.color = "white";
		l3.style.color = "white";
		
		for(var i=0; i < mItem.length; i++) {
			mItem[i].style.color = "white";
		}
    }else if(window.scrollY < 1) {
        section.style.backgroundColor = "white";
		l1.style.color = "black";
		l2.style.color = "black";
		l3.style.color = "black";
		
		for(var i=0; i < mItem.length; i++) {
			mItem[i].style.color = "black";
		}
	}*/
};

function getPageHeight(){
	var body = document.body,
    html = document.documentElement;

	var height = Math.max( body.scrollHeight, body.offsetHeight, 
                       html.clientHeight, html.scrollHeight, html.offsetHeight );
	
	let footer = document.getElementById("footer");
	let total = height + 30;
	footer.style.marginTop = total + "px";
	footer.style.display = "inline-block";
	console.log(height);
}

document.addEventListener("DOMContentLoaded", function(event) {
	if(document.getElementById("btnLogin") != null){
		document.getElementById('btnLogin').onclick = doLogin;
		document.getElementById("l3").style = "display: none;";
	}
	else{
		document.getElementById("l3").style = "display: block;";
	}
	getPageHeight();
	currentPage();
 });

function toggleDropDownContent(){
	dropDownVisible = !dropDownVisible;
	
	if(dropDownVisible){
		document.getElementsByClassName('dropdown-content')[0].style = "display: block !important;";
	}else{
		document.getElementsByClassName('dropdown-content')[0].style = "display: none !important;";	
	}
}

function currentPage(){
	
	let selectable = document.getElementsByClassName("head-section-item");
	let currentURI = document.URL;
	if(currentURI === "https://popfrag.eu/"){
		selectable[0].style.color = "orange";
	}else if(currentURI === "https://popfrag.eu/forum"){
		selectable[1].style.color = "orange";
	}else if(currentURI === "https://popfrag.eu/servery"){
		selectable[2].style.color = "orange";
	}else if(currentURI === "https://popfrag.eu/kontakt"){
		selectable[3].style.color = "orange";
	}else if(currentURI.includes("https://popfrag.eu/clanek")){
		selectable[0].style.color = "orange";
	}
}

function getCookie(name) {
    // Split cookie string and get all individual name=value pairs in an array
    var cookieArr = document.cookie.split(";");
    
    // Loop through the array elements
    for(var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");
        
        /* Removing whitespace at the beginning of the cookie name
        and compare it with the given string */
        if(name == cookiePair[0].trim()) {
            // Decode the cookie value and return
            return decodeURIComponent(cookiePair[1]);
        }
    }
    
    // Return null if not found
    return null;
}

function doLogin(){
	let username = document.getElementById("txtUser");
	let password = document.getElementById("txtPass");
	
	if(username.value.length > 2 && password.value.length > 5){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let result = this.responseText;
				
				if(result == "success"){
					location.reload();
				}else{
					document.getElementById("failureText").innerHTML = "Neplatné přihlašovací údaje. Zapomenuté heslo? Resetuj si heslo <a class='login-panel-register' href='https://popfrag.eu/forum/ucp.php?mode=sendpassword'>zde</a>";
					document.getElementById("loginFail").style.display = "block";
				}
			}
		};
		xhttp.open("GET", "https://popfrag.eu/resources/classes/login.php?username=" + username.value + "&password=" + password.value, true); 
		xhttp.send(); 
	}else{
		document.getElementById("failureText").innerHTML = "Musíš vyplnit obě pole.";
		document.getElementById("loginFail").style.display = "block";
	}
}