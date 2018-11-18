<section>
    <div class="cont">
        <?php if(empty($orders)): ?>
        <div class="alert alert-info" role="alert"> У вас нет заказов!</div>
        <?php else: ?>
        <?php foreach($orders as $order): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="5">Номер заказа № <b><?= $order[0]['id']; ?></b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5">Дата заказа :<span class="itemName"><?= $order[0]['date_on']; ?></span>
                        </td>
                    </tr>                    
                    <tr>
                        <td colspan="5">На сумму :<span class="itemName"><?= $order[0]['sell']; ?></span>
                        </td>
            
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <th>№</th>
                        <th>Товар</th>
                        <th>Кол.</th>
                        <th class="pravo">Цена</th>
                        <th class="pravo">Сумма</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach($order[0]['products'] as $product): ?>
                    <tr>
                        <td width="2%"><?php echo $i; $i++; ?></td>
                        <td><?php echo '<span class="itemName">'.$product['name'].'</span> '. $product['spec']; ?><?php if($product[ 'convert_t']>1 ) echo '<span class="convert">'.$product['sell'] * $product['convert_t'].' сом</span>'; ?></td>
                        <td><?= $product['count']; ?></td>
                        <td class="pravo"><?php if($product[ 'convert_t']>1 ): ?>
                              <?php echo number_format($product['convert_t'] * $product['sell'], 2, '.', ' '); ?>
                              <?php else : ?>
                              <?php echo number_format($product['sell'], 2, '.', ' '); ?>
                              <?php endif; ?></td>
                        <td class="pravo"><?php if($product['convert_t'] > 1): ?>
                              <?php $summ = ($product['count'] * $product['sell']); ?>
                              <?php echo number_format($summ * $product['convert_t'], 2, '.', ' '); ?>
                              <?php else : ?>
                              <?php echo number_format($product['count'] * $product['sell'], 2, '.', ' '); ?>
                              <?php endif; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php if($order[0]['get_bonus'] > 0): ?>
                <tfoot>
                    <tr class="center">
                        <td colspan="5"><b>Сумма бонусов :<span class="convert"><?= $order[0]['get_bonus']; ?></span></b></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

