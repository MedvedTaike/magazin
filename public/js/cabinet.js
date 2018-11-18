var cart = {};
var update = {};
checkCart();
$(function(){
    if (!$.isEmptyObject(cart)) {
        getTotal();
    }
    $(document).on('click', '#search', searchItem);
    $(document).click(function(){
        if($('#search-item').is(':visible')){
            $('#search-item').fadeOut();
        }
    });
    $(document).on('click', '.controls', setUpdate);
    $(document).on('click', '#get-bonus', getBonus);
});
function getTotal() {
    var total = 0;
    for (var key in cart) {
        total += cart[key]['summ'];
    }
    $('#cart').html(total.toFixed(2));
    $('#total-summ').html(total.toFixed(2));
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
function checkCart(){
    if (sessionStorage.getItem('cart') != null) {
        cart = JSON.parse(sessionStorage.getItem('cart'));
    }
}
function setUpdate(){
    var id = $(this).attr('id');
    $('.order-row').each(function(){
        var cur = $(this);
        var id = cur.attr('id');
        var count = parseFloat(cur.find('.number').text());
        var convert = parseFloat(cur.find('span.convert').text());
        var price = parseFloat(cur.find('.cena').text());
        var name = cur.find('.itemName').text();
        var desc = cur.find('span.cart-spec').text();
        if(isNaN(convert)){
            convert = "";
        } else {
            price = convert;
        }
        update[id] = {
            count: count,
            convert: convert,
            price: price,
            summ: (count * price),
            name: name,
            desc: desc
        };
    });
    $.ajax({
        url: "/ajax/setUpdate",
        method: "POST",
        data: {
            id: id
        },
        success: function(data){
            if(id == data){
                sessionStorage.setItem('cart', JSON.stringify(update));
                $(location).attr('href',"/product/1");
            }
        }
    });
}
function getBonus(){
    $.ajax({
        url: "/ajax/getBonus",
        success: function(data){
            if(data == 1){
                location.reload();
            } else {
                wrongBonus();
            }
        }
    });
}
function wrongBonus(){
    $('.informing').text('Не удалось получить бонус ! Попробуйте позже !');
    $('.informing').fadeIn();
}
