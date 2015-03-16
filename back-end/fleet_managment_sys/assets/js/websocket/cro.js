function subscribe(userid) {
    console.log("DEBUG: SUBSCRIBE: "+userid);
    var conn = new ab.Session(
        'ws://' + ApplicationOptions.constance.WEBSOCKET_URL + ':' + ApplicationOptions.constance.WEBSOCKET_PORT,
        function () {
            conn.subscribe(userid, function (topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                console.log('DEBUG: New Message published to user "' + topic + '" : ' + data.message);
                console.log(data);
                var messageData = data.message;
                if(data.source === 'pabx'){
                    var incommingCall = $.UIkit.notify({
                        message: "Incomming call from <span onclick='$(\"#tpSearch\").val(\""+messageData.number+"\")' style='cursor: pointer;color: red'>"+messageData.number+"</span> <br/>To extension<span style='color: #0000FF'>"+ messageData.ext+"</span>",
                        status: 'success',
                        timeout: 20000,
                        pos: 'top-center'
                    });
                    $(incommingCall.element).children().filter(":not(.uk-close)").on('click', function(e) {e.preventDefault();return false;});

                }
                else{
                    var delayInform = $.UIkit.notify({
                        message: "Order # = <span onclick='$(\"#tpSearch\").val(\""+messageData.tp+"\")' style='cursor: pointer;color: red'>"+messageData.refId+"</span> request to delay<br/><span style='color: #0000FF'>"+ messageData.delay_minutes+" minutes</span> from cro(ID): "+messageData.croId+"<br/>Customer number <b>"+messageData.tp+"</b>",
                        status: 'warning',
                        timeout: 0,
                        pos: 'top-center'
                    });
                    $(delayInform.element).children().filter(":not(.uk-close)").on('click', function(e) {e.preventDefault();return false;});

                }
            });
        },
        function () {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
}

subscribe('cro1');