let conn = new ab.Session('ws://127.0.0.1:8080',
        function () {
            conn.subscribe('eventMonitoring', function (topic, data) {
                console.log(data);
            });
        },
        function () {
            console.log(console.warn('WebSocket connection closes'));
        },
        {'skipSubprotocolCheck': true}
    );