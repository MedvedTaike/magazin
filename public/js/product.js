var cart = {};
var start = getWindowSize();
$(function(){
    checkCart();
    if (!$.isEmptyObject(cart)) {
        getTotal();
        orderedItems();
    }
    loadImages();
    $('.btn-danger').click(function(){
        var parent = $(this).parents('.card');
        var articul = parseInt(parent.attr('id'));
        cart[articul] = {
            count: getCount(articul)
        }
        if (this.id == "plus") {
            cart[articul].count++;
            formingCart(articul);
        } else if (this.id == "minus") {
            if (cart[articul].count > 1) {
                cart[articul].count--;
                formingCart(articul);
            } else {
                delete cart[articul];
                formingCart(articul);
            }
        }
    });
    $(document).on('click', '#search', searchItem);
    $(document).click(function(){
        if($('#search-item').is(':visible')){
            $('#search-item').fadeOut();
        }
    });
    $(window).on('scroll', function(event){
        if($(window).scrollTop() >= 200 ){
            loadAllImages();
            $(this).off(event);
        }
    });
});
function checkCart() {
    if (sessionStorage.getItem('cart') != null) {
        cart = JSON.parse(sessionStorage.getItem('cart'));
    }
}
function saveCart() {
    sessionStorage.setItem('cart', JSON.stringify(cart));
}
function getCount(articul) {
    var count = 0;
    if (cart[articul] !== undefined) {
        count = cart[articul].count;
    }
    return count;
}
function prepare() {
    saveCart();
    checkCart();
}
function formingCart(articul) {
    var parent = $('#' + articul);
    if (cart[articul] !== undefined) {
        var convert = parseFloat(parent.find('.convert').text());
        var price = parseFloat(parent.find('.sell').text());
        if (!isNaN(convert)) {
            price = convert;
        }
        cart[articul].convert = parent.find('.convert').text();
        cart[articul].summ = price * cart[articul].count;
        cart[articul].price = price;
        cart[articul].name = parent.find('.item_name').text();
        cart[articul].desc = parent.find('.spec_name').text();
        parent.find('.count').fadeIn('fast');
        parent.find('.quant').html(cart[articul].count);
        parent.find('.summ').html(cart[articul].summ.toFixed(2));

    } else {
        parent.find('.count').fadeOut('fast');
    }
    prepare();
    getTotal();
}

function getTotal() {
    var total = 0;
    for (var key in cart) {
        total += cart[key]['summ'];
    }
    $('#cart').html(total.toFixed(2));
    $('#total-summ').html(total.toFixed(2));
}

function orderedItems() {
    for (var key in cart) {
        var parent = $('#' + key);
        parent.find('.count').fadeIn('fast');
        parent.find('.quant').html(cart[key].count);
        parent.find('.summ').html(cart[key].summ.toFixed(2));
    }
}
function searchItem(){
    var value = $(this).parents('.input-group').find('.form-control').val();
    if(value !== ''){
        $.ajax({
            url: "/ajax/findProduct",
            method: "POST",
            data: {
                value:value
            },
            success: function(data){
                $('#search-item').fadeIn();
                $('#search-item').html(data);
            }
        });
    } else {
        $('#search-item').fadeIn();
        $('#search-item').html('<div class="alert alert-warning" role="alert">Заполните поле поиска!</div>');
    }
}
function loadImages(){
    var elems = $('img');
    for(var i = 0; i < start; i++){
        var id = elems.eq(i).parents('.card').attr('id');
        elems.eq(i).attr('src', '/public/img/'+id+'.jpg');
    }
}
function loadAllImages(){
    var elems = $('img');
    for(var i = start, count = elems.length; i < count; i++){
        var id = elems.eq(i).parents('.card').attr('id');
        elems.eq(i).attr('src', '/public/img/'+id+'.jpg');
    }
}
function getWindowSize(){
    var out = 0;
    if($(window).width() >= 1290){
        out = 15;
    } else if($(window).width() <= 1289 && $(window).width() >= 992){
        out = 10;
    } else if($(window).width() <= 991 && $(window).width() >= 768){
        out = 8;
    }else if($(window).width() <= 767 && $(window).width() >= 320){
        out = 6;
    }else if($(window).width() <= 319 ){
        out = 4;
    }
    return out;
}


