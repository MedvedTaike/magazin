<section>
    <div class="cont">
        <div class="div-content">
            <div class="alert alert-danger notification" role="alert">Ваш заказ не был оформлен! Попробуйте позже!</div>
            <h4 class="category-name" id="cart-header"></h4>
            <div class="table-responsive" id="cart-table">
            </div>
            <div class="forming-buttons">
                <a class="btn btn-primary controls" href="/product/1">Добавить товар</a>
                <?php if(!isset($_SESSION['update'])): ?>
                <?='<button class="btn btn-primary controls" id="create-order">Оформить заказ</button>' ; ?>
                <?php else: ?>
                <?='<button class="btn btn-primary controls" id="update-order">Редактировать заказ</button>' ; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>