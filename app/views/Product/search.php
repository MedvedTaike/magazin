<section>
    <div class="cont">
        <div class="row-align">
            <?php foreach($product as $id=>$item): ?>
            <div class="item">
                <div class="card text-center" id="<?= $item['id']; ?>">
                   <div class="count">
                     <div class="d-flex align-items-center">
                      <div class="wrap_1"><span class="quant"></span></div>                     
                      <div class="wrap_2"><span class="summ"></span></div>
                     </div>
                   </div>
                    <img class="card-img-top" src="/public/img/<?php echo $item['id']; ?>.jpg">
                    <div class="card-body">
                        <h5 class="card-title sell"><?php echo $item['sell']; ?></h5>
                        <h6 class="card-title item_name"><?php echo $item[ 'name'] ;?></h6>
                        <p class="card-text spec_name"><?php echo $item[ 'spec'] ;?></p>
                        <?php if($item[ 'convert_t']>1 ) echo '(<span class="convert">'.$item['sell'] * $item['convert_t'].' сом</span>)'; ?>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" id="minus">-</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" id="plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>