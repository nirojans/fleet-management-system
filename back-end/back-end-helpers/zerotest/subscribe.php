<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script>
function subscribe(userid){
    var userdid = document.getElementById('userid').value;
    var conn = new ab.Session('ws://127.0.0.1:8080',
        function() {
            conn.subscribe(userdid, function(topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                alert('New Message published to user "' + topic + '" : ' + data.message);
            });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
}
</script>
<input type="text" id="userid" name="userid"/>
<input type="button" value="Subscribe" onClick="subscribe('1');">
