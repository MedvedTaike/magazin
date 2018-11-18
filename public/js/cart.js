cart = {};
checkCart();
$(function(){
    if (!$.isEmptyObject(cart)) {
        fullCart();
        if($(window).width() > 480){
                bigScreen();
            } else {
                smallScreen();
            }
        $(window).resize(function(){
            if($(window).width() > 480){
                bigScreen();
                getTotal();
            } else {
                smallScreen();
            }
        });
        getTotal();
    } else {
        emptyCart();
    } 
    $(document).on('click', '.delete', deleteItem);
    $(document).on('click', '#create-order', createOrder);
    $(document).on('click', '#update-order', updateOrder);
    $(document).on('click', '#search', searchItem);
    $(document).click(function(){
        if($('#search-item').is(':visible')){
            $('#search-item').fadeOut();
        }
    });
});
function checkCart() {
    if (sessionStorage.getItem('cart') != null) {
        cart = JSON.parse(sessionStorage.getItem('cart'));
    }
}
function getTotal() {
    var total = 0;
    for (var key in cart) {
        total += cart[key]['summ'];
    }
    $('#cart').html(total.toFixed(2));
    $('#total-summ').html(total.toFixed(2));
}
function bigScreen() {
    var out = '';
    var num = 1;
    out += '<table class="table table-sm table-striped">';
    out += '<thead><tr>';
    out += '<th scope="col">№</th><th scope="col">Товар</th><th scope="col" class="center">Кол.</th><th scope="col" class="pravo">Цена</th><th scope="col" class="pravo">Сумма</th><th scope="col" class="center">Удалить</th></tr></thead>';
    out += '<tbody>';
    for (var key in cart) {
        out += '<tr><td>' + num + '</td>';
        out += '<td class="itemName" align="left">' + cart[key]['name'] + '<span class="cart-spec">' + cart[key]['desc'] + '</span><span class="convert">' + cart[key]['convert'] + '</span></td>';
        out += '<td class="center">' + cart[key]['count'] + '</td>';
        out += '<td class="pravo">' + cart[key]['price'].toFixed(2) + '</td>';
        out += '<td class="pravo">' + cart[key]['summ'].toFixed(2) + '</td>';
        out += '<td class="delete center" id="' + key + '"><i class="fa fa-times" aria-hidden="true"></i></td></tr>';
        num++;
    }
    out += '</tbody>';
    out += '<tfoot><td colspan="4" class="pravo">Общая сумма за товары</td><td class="pravo" id="total-summ"></td><td></td></tfoot></table>';
    $('#cart-table').html(out);
}
function fullCart(){
    $('#cart-header').text('Товары в вашей корзине :');
    $('#create-order').fadeIn();
}
function emptyCart(){
    $('#cart-header').text('В вашей корзине нет товаров !');
    $('#create-order').fadeOut();
    $('.table').fadeOut();
}
function smallScreen(){
    var out = '';
    out += '<table class="table table-sm table-hover">';
    for(var key in cart){
        out += '<tbody class="border-custom" id="'+key+'">';
        out += '<tr class="item-name"><td width="100%" colspan="2">' + cart[key]['name'] + '<p><span class="cart-spec">' + cart[key]['desc'] + '</span></p><span class="convert">' + cart[key]['convert'] + '</span><td></tr>'; 
        out += '<tr><td width="50%" align="right">Цена :</td><td width="50%" align="left">' + cart[key]['price'].toFixed(2) + '</td></tr>';
        out += '<tr><td width="50%" align="right">Количество :</td><td width="50%" align="left">' + cart[key]['count'] + '</td></tr>';
        out += '<tr><td width="50%" align="right">Сумма :</td><td width="50%" align="left">' + cart[key]['summ'].toFixed(2) + '</td></tr>';
        out += '<tr><td width="50%" align="right">Удалить </td><td width="50%" align="left" class="delete" id="' + key + '"><i class="fa fa-times" aria-hidden="true"></i></td></tr>';
        out += '</tbody>';
    }
    out += '</table>';
    $('#cart-table').html(out);
}
function saveCart() {
    sessionStorage.setItem('cart', JSON.stringify(cart));
}
function prepare(){
    saveCart();
    checkCart();
}
function deleteItem() {
    var articul = $(this).attr('id');
    if($(window).width() > 480){
        $(this).parent('tr').fadeOut();
    } else {
        $(this).parents('tbody').fadeOut();
    }
    delete cart[articul];
    prepare();
    getTotal();
    clearCart();
}
function clearCart(){
    if($.isEmptyObject(cart)){
        emptyCart();
    }
}
function updateOrder(){
    var order = {};
    for(var key in cart){
        order[key] = cart[key]['count'];
    }
    $.ajax({
        url: "/ajax/updateOrder",
        method: "POST",
        data: {
            order: order,
        },
        success: function(data){
            if(data == 1){
                successfullUpdate();
            } else {
                notSuccessfullUpdate();
            }
        }
    })
}
function createOrder() {
    var order = {};
    for (var key in cart) {
        order[key] = cart[key]['count'];
    }
    $.ajax({
        url: "/ajax/createOrder",
        method: "POST",
        data: {
            order:order
        },
        success: function(data){
            if(data == 1){
                orderCreated();
            } else if(data == 0){
                alreadyHave();
            } else if(data == 2){
                somethingWrong();
            }
        }
    });
}
function orderCreated(){
    $('.div-content').replaceWith('<div class="alert alert-success" role="alert"><h4 class="alert-heading">Ваш заказ оформлен!</h4>');
    sessionStorage.clear();
    $('#cart').html('0.00');
}
function alreadyHave(){
    $('.div-content').replaceWith('<div class="alert alert-danger" role="alert"><h4 class="alert-heading">У вас уже есть не обработанный заказ вы можете его редактировать<a href="/cabinet" class="alert-link"> здесь </a>!</h4>');
    sessionStorage.clear();
    $('#cart').html('0.00');
}
function somethingWrong(){
    $('.notification').fadeIn();
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
function successfullUpdate(){
    $('.div-content').replaceWith('<div class="alert alert-success" role="alert"><h4 class="alert-heading">Ваш заказ отредактирован!</h4>');
    sessionStorage.clear();
    $('#cart').html('0.00');
}
function notSuccessfullUpdate(){
    $('.div-content').replaceWith('<div class="alert alert-danger" role="alert"><h4 class="alert-heading">Ваш заказ не отредактрован попоробуйте позже !</h4>');
}

