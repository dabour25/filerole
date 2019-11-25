setInterval(function(){
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var starttime = new Date(date+" 09:00:00").getTime();
    var endtime = new Date(date+" 17:00:00").getTime();
    var ts = today - starttime;
    var t = endtime - today;
    var shours = Math.floor((ts%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
    var sminutes = Math.floor((ts % (1000 * 60 * 60)) / (1000 * 60)); 
    var sseconds = Math.floor((ts % (1000 * 60)) / 1000); 
    var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
    var seconds = Math.floor((t % (1000 * 60)) / 1000); 
    $('#date').text(date);
    $('#time').text(time);
    $('#last').text(shours+":"+sminutes+":"+sseconds);
    $('#rem').text(hours+":"+minutes+":"+seconds);
    $('#remhrs').text('Hrs:'+hours);
    $('#remmin').text('Min:'+(minutes+hours*60));
    $('#remsec').text('Sec:'+(seconds+minutes*60+hours*60*60));
    var precentage=parseInt((30600-(seconds+minutes*60+hours*60*60))*100/30600);
    $('#progress').text(precentage+' %');
    $('#progress').width(precentage+'%');
    if(precentage>80){
        $( "#progress" ).removeClass( "bg-danger" );
        $("#progress").removeClass("bg-warning");
        $("#progress").removeClass("bg-info");
        $("#progress").removeClass("bg-primary");
        $("#progress").addClass("bg-success");
    }else if(precentage>60){
        $( "#progress" ).removeClass( "bg-danger" );
        $("#progress").removeClass("bg-warning");
        $("#progress").removeClass("bg-info");
        $("#progress").addClass("bg-primary");
    }else if(precentage>40){
        $( "#progress" ).removeClass( "bg-danger" );
        $("#progress").removeClass("bg-warning");
        $("#progress").addClass("bg-info");
    }else if(precentage>20){
        $( "#progress" ).removeClass( "bg-danger" );
        $("#progress").addClass("bg-warning");
    }
    //Cash Calculation
    var ts_sec=parseInt((sseconds+sminutes*60+shours*3600));
    var cash=parseFloat(ts_sec*0.0078125).toFixed(3);
    var cash_usd=parseFloat(cash/16.14).toFixed(3);
    $('#cash').text(cash);
    $('#cashusd').text(cash_usd);
}, 1000);