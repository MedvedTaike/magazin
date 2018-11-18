<section>
    <div class="container-fluid">
        <div class="head">
            <div class="cont">
                <p class="logotype">ARZAN.biz<span class="spec"> ....онлайн опто-маркет !</span>
                </p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="cont">
            <div class="vhod">
                <div class="card text-center border-yellow">
                    <div class="card-header background-yellow">
                        <h5 class="card-title">Вход на сайт</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="post">
                            <div class="form-group">
                                <?php if(isset($errors['phone'])): ?>
                                <?= '<label for="phone" style="color:red">Такого пользователя нет !</label>'; ?>
                                <?php else: ?>
                                <?= '<label for="phone">Введите телефон</label>'; ?>
                                <?php endif; ?>
                                <input type="tel" class="form-control" name="phone" placeholder="0700******" pattern="0[0-9]{9}" value="<?= @$data['phone']; ?>" required>
                                <small class="form-text text-muted">Пример 0772123456</small>
                            </div>
                            <div class="form-group">
                                <?php if(isset($errors['pass'])): ?>
                                <?= '<label for="pass" style="color:red">Неправильно введен пароль!</label>'; ?>
                                <?php else: ?>
                                <?= '<label for="pass">Пароль</label>' ; ?>
                                <?php endif; ?>
                                <input type="password" class="form-control" name="password" placeholder="Ваш пароль" pattern="[A-Za-z0-9-_]{6,20}" required >
                                <small class="form-text text-muted">Не менее шести символов!</small>
                            </div>
                            <button type="submit" name="do_login" class="btn btn-primary">Вход</button>
                        </form>
                    </div>
                    <div class="card-footer background-yellow">
                        <button class="btn btn-primary" id="e-mail">Регистрация</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


