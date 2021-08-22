

var notif = null;


$(function(){
    
    var conn = new WebSocket('ws://localhost:8000');
    
    conn.onopen = function(e){
        console.log("Notification : Connection Established!");
    }

    conn.onerror= function(e){
        console.log("Notification : Connection Error");
    }
    
    conn.onmessage = function(e){

        var data = JSON.parse(e.data);
        
        var body = data.requestedBy +" : "+ data.remarks;
        toastr.info(body,data.message);
        loadRequest();
    };

    notif = function(data){
        conn.send(JSON.stringify(data));
    }

});