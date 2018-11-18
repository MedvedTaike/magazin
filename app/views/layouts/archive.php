<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arzan.biz</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/font-awesome.min.css">
    <link href="/public/css/product.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar fixed-top bg-yellow">
        <div class="cont">
            <div class="d-flex">
                <div class="mr-auto px-1">
                    <div class="dropdown show">
                        <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Меню</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <?php foreach($menuItem as $item): ?>
                            <a class="dropdown-item" href="/product/<?= $item['id']; ?>"><?= $item['name']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <div class="dropdown show">
                        <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownLogin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="nav_name"><?= $_SESSION['name']; ?></span><i class="fa fa-user"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownLogin">
                            <a class="dropdown-item" href="/cabinet">Кабинет</a>
                            <a class="dropdown-item" href="/site/logout">Выйти</a>
                        </div>
                    </div>
                </div>
                <div class="px-1">
                    <a href="/cart/" class="btn btn-warning"><span class="nav_name">Корзина</span><i class="fa fa-shopping-cart"></i><span id="cart">0.00</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <header>
        <div class="cont">
            <div class="kopf">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mr-auto p-3">
                        <p class="logotype">ARZAN.biz<span class="spec"> ....де баардыгы ар дайым Арзан!!!</span>
                        </p>
                    </div>
                    <div class="pad-right">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Введите имя товара" maxlength="14">
                            <div class="input-group-append">
                                <button class="btn btn-outline-warning" type="button" id="search">Поиск</button>
                            </div>
                            <div class="dropdown-menu" id="search-item">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <?=$content; ?>

        <footer class="bg-yellow">
            <div class="cont ">
                <div class="d-flex">
                    <div class="mr-auto px-1">
                        <button class="btn btn-warning" id="e-mail">Написать <i class="fa fa-envelope-o"></i>
                        </button>
                    </div>
                    <div class="px-1">
                        <button class="btn btn-warning">0772092008 <i class="fa fa-phone"></i>
                        </button>
                    </div>
                </div>
            </div>
        </footer>
            <script src="/public/js/jquery-3.1.0.min.js"></script>
            <script src="/public/js/bootstrap.min.js"></script>
            <script src="/public/js/archive.js"></script>
</body>
</html>