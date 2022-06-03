<script>
let key = "p8ofo4nds5em9p89csat2afklwrioy";
let sterakId= "39661750";
var data = null;

var xhr = new XMLHttpRequest();

xhr.addEventListener("readystatechange", function () {
  if (this.readyState === this.DONE) {
    console.log(this.responseText);
  }
});

xhr.open("GET", "https://api.twitch.tv/kraken/channels/" + sterakId + "/subscriptions");
xhr.setRequestHeader("accept", "application/vnd.twitchtv.v5+json");
xhr.setRequestHeader("Client-ID", "y2t5ke2d02wrlj9egeil45h27mgbzj");
xhr.setRequestHeader("Authorization", "OAuth " + key);
xhr.send(data);

</script>

<body>
</body>