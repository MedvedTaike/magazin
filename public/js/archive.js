var cart = {};
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
});
function getTotal() {
    var total = 0;
    for (var key in cart) {
        total += cart[key]['summ'];
    }
    $('#cart').html(total.toFixed(2));
    $('#total-summ').html(total.toFixed(2));
}
function checkCart(){
    if (sessionStorage.getItem('cart') != null) {
        cart = JSON.parse(sessionStorage.getItem('cart'));
    }
}