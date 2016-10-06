$(document).ready(function(){
    refresh();
});

function refresh(){
    loading();
    $.get("getNews.php", function (data){
        stopLoading();
        var xml = $.parseXML(data)
        $(xml).find("item").each(function (){
            var item = $(this);
            var isVoetbal = false;
            item.find("category").each(function (){
                if($(this).text() == "Voetbal"){
                    isVoetbal = true;
                }
            });
            if(isVoetbal){
                $("#newsItems").append('<div class="newsItem"><a class="news" href="' + item.find("link").text() + '">' + item.find("title").text() + '</a></div>');
            }
        });
    });
}

function loading(){
    $("#loading").css("display", "block");
}

function stopLoading(){
    $("#loading").css("display", "none");
}