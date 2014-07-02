$(function (){
    function Application(){
        this.initCallbacks = function fun(){
            $('#filter').click(function (){
                var color = $('#color').val() != -1 ? $('#color').val() : undefined;
                var material = $('#material').val() != -1 ? $('#material').val() : undefined;
                var data = {
                    Color: color,
                    Material: material,
                    FromHeight: $('#from-height').val(),
                    ToHeight: $('#to-height').val(),
                    FromWidth: $('#from-width').val(),
                    ToWidth: $('#to-width').val(),
                    FromPrice: $('#from-price').val(),
                    ToPrice: $('#to-price').val()
                };
                $.get("/?r=site/index&page=1#menu", data, function (res){
                    document.body.innerHTML = res;
                    $(window).scrollTop($('#menu').offset().top);
                    fun();
                });
            });
        }
    }
    
    var application = new Application();
    application.initCallbacks();
});