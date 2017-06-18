function SetAdsBlocks() {
    for(var i = 1; i < ads.length; i++) {
        if (ads[i] == undefined)
            SetAsEmptyAdsBlock(i);
        else if (ads[i].length == 0)
            SetAsEmptyAdsBlock(i);
        else if (ads[i].length > 1)
            (function(i){
                var j = 0;

                setInterval(function(){
                    var image = ads[i][j].img_link;
                    var link = ads[i][j].redirect_url;

                    $("#ads-block-" + i).css("background-image", "url('" + image + "')");

                    document.getElementById("ads-block-" + i).onclick = function () {
                        var win = window.open(link, '_blank');
                        win.focus();
                    };

                    j++;

                    if (j >= ads[i].length)
                        j = 0;

                }, 5000);
            }(i));
        else
            $("#ads-block-" + i).css("background-image", "url('" + ads[i][0].img_link + "')");
    }
}

function SetAsEmptyAdsBlock(id) {
    $("#ads-block-" + id).html("Разместить рекламу");

    document.getElementById("ads-block-" + id).onclick = function () {
        var win = window.open("/ads", '_blank');
        win.focus();
    };
}

function SetAdsBlocksAsPayable() {
    for(var i = 1; i < ads.length; i++) {
        $("#ads-block-" + i).html("Купить этот блок");

        document.getElementById("ads-block-" + i).onclick = function () {
            alert("Плати и забирай! :-)");
        };
    }
}