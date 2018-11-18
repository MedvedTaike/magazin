<section>
    <div class="cont">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Магазин <b><?= $current[0]['magazin']; ?></b>
                        </th>
                        <th colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Адресс :
                            <span class="itemName"><?= $current[0]['address']; ?></span>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Телефон :
                            <span class="itemName"><?= $current[0][ 'phone']; ?></span>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Дата регистрации :
                            <span class="itemName"><?= $current[0][ 'date']; ?></span>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Бонусы :
                            <span class="itemName"><?= $bonus; ?></span>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>
                            <?php if($bonusAvail): ?>
                            <?='<button type="button" class="btn btn-primary" id="get-bonus">Получить бонусы</button>' ;?>
                            <?php else : ?>
                            <?='<button type="button" class="btn btn-secondary" disabled>Получить бонусы</button>' ; ?>
                            <?php endif; ?>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                    <?php if(empty($lastOrder)): ?>
                    <tr>
                        <td><div class="alert alert-info informing" role="alert"> У вас нет активных заказов!</div></td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
            <?php else: ?>
            <tr>
                <td>Ваш последний заказ №
                    <span class="itemName"><?=$lastOrder[0]['id']; ?></span>
                </td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>Дата заказа :
                    <span class="itemName"><?=$lastOrder[0]['date_on']; ?></span>
                </td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td>На сумму :
                    <span class="itemName"><?=$lastOrder[0]['sell']; ?></span>
                </td>
                <td colspan="3"></td>
            </tr>
            </tbody>
            </table>
            <div class="table-responsive">
                <table class="table table-striped">
                   <thead>
                       <tr>
                           <th>#</th>
                           <th>Товар</th>
                           <th class="center">Кол.</th>
                           <th class="pravo">Цена</th>
                           <th class="pravo">Сумма</th>
                       </tr>
                   </thead>
                   <tbody class="border-custom">
                      <?php $i = 1; ?>
                       <?php foreach($lastOrder[0]['products'] as $item):?>
                       <tr id="<?= $item['id']; ?>" class="order-row" >
                           <td width="2%"><?php echo $i; $i++;?></td>
                           <td><span class="itemName"><?=$item['name']; ?></span><span class="cart-spec"><?=$item['spec'];?></span><?php if($item[ 'convert_t']>1 ) echo '<span class="convert">'.$item['sell'] * $item['convert_t'].' сом</span>'; ?></td>
                           <td class="center number"><?php echo $item['count']; ?></td>
                           <td class="pravo cena"><?php if($item[ 'convert_t']>1 ): ?>
                                             <?php echo number_format($item['convert_t'] * $item['sell'], 2, '.', ' '); ?>
                                             <?php else : ?>
                                             <?php echo number_format($item['sell'], 2, '.', ' '); ?>
                                             <?php endif; ?></td>
                           <td class="pravo"><?php if($item['convert_t'] > 1): ?>
                                             <?php $summ = ($item['count'] * $item['sell']); ?>
                                             <?php echo number_format($summ * $item['convert_t'], 2, '.', ' '); ?>
                                             <?php else : ?>
                                             <?php echo number_format($item['count'] * $item['sell'], 2, '.', ' '); ?>
                                             <?php endif; ?></td>
                       </tr>
                       <?php endforeach; ?>
                   </tbody>
                   <?php if($lastOrder[0]['get_bonus'] > 0): ?>
                    <tfoot>
                        <tr class="center">
                            <td colspan="5"><b>Сумма бонусов :<span class="convert"><?= $lastOrder[0]['get_bonus']; ?></span></b></td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
            <div class="forming-buttons">
                <button type="button" class="btn btn-primary controls" id="<?= $lastOrder[0]['id']; ?>">Редактровать/Добавить товар</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="forming-buttons">
            <a class="btn btn-primary controls" href="/cabinet/archive" role="button">Посмотреть архив заказов</a>
        </div>
    </div>
</section>
