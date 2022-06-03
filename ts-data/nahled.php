<!DOCTYPE html>
<html lang="cs">
	<head>
		<!--meta charset="utf-8">-->

		<title>PopFrag.eu TeamSpeak 3 </title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://{DOMENA}.{TLS}/tsdata/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">

    </head>
		
	<body>
		<header>
			<div class="navbar">
				<div class="navbar_holder" id="navbar_holder">
					<div class="navbar_left">
						<a class="navbar_ip">ts.popfrag.eu</a>
						<a href="https://{DOMENA}.{TLS}/tsdata"><div class="navbar_item">Přehled</div></a>
						<div class="splitter">|</div>
						<div class="navbar_item_active">Náhled serveru</div>
						<div class="splitter">|</div>
						<div class="navbar_item">Ikonky</div>
						<div class="splitter">|</div>
						<div class="navbar_item">Bany</div>
					</div>
				</div>
			</div>
		</header>

        <div class="viewerContainer">
            <h1 class="viewer">Aktuální přehled</h1>
            <?php
                require_once("lib/TeamSpeak3.php");

                // connect to local server, authenticate and spawn an object for the virtual server on port 9987
                $ts3_VirtualServer = TeamSpeak3::factory("serverquery://PopFrag_data:HQVqy0UY@82.208.17.98:10011/?server_port=6376");
                               
                
                $ts3_VirtualServer->setLoadClientlistFirst(TRUE);
                $ts3_VirtualServer->setExcludeQueryClients(true); 
                echo $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("images/viewer/", "images/flags/", "data:image"));
            ?>
            
        </div>
        <script>


            window.onresize = function(event) {
                

                let element = document.getElementsByClassName("ts3_viewer channel");

                let width = element[0].offsetWidth - 58;
               
                let spacers = document.getElementsByClassName("corpus spacer");
  
                for(let i = 0, len = spacers.length; i < len; i++){
                    spacers[i].style.maxWidth = width + "px";
                }
            };

            let element = document.getElementsByClassName("ts3_viewer channel");

                let width = element[0].offsetWidth - 58;
               
                let spacers = document.getElementsByClassName("corpus spacer");
  
                for(let i = 0, len = spacers.length; i < len; i++){
                    spacers[i].style.maxWidth = width + "px";
            }

            document.addEventListener('click', function(e) {

                e = e || window.event;
                var target = e.target || e.srcElement,
                text = target.className;
                if(text == "corpus channel"){
                    let summary = target.parentElement.parentElement.parentElement.getAttribute("summary");
                    window.location.href = "ts3server://82.208.17.98/?port=6376&nickname=Návštěvník&cid=" + summary;   
                }else if(text == "corpus server"){
                    window.location.href = "ts3server://82.208.17.98/?port=6376&nickname=Návštěvník";
                }
            }, false);
        </script>
    </body>
</html>