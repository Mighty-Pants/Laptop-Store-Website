<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="product_summary.php"><img src="themes/images/ico-cart.png" alt="cart">
    <?php
      if($login_check==true){
        echo Session::get('qty');
    }else echo '0';
    ?> 
    sản phẩm trong giỏ </a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        <?php
        $cat = new category();
        $producer = new Producer();
        
        $getAllCat = $cat->get_category();
        if($getAllCat){
            while($resCat = $getAllCat->fetch_assoc()){

        ?>
        <li class="subMenu open"><a><?php echo $resCat['Name'] ?></a>
            <ul>
            <?php
                $getProducer = $producer->getProducerByCatId($resCat['ID']);
                if($getProducer){
                    while($resPro = $getProducer->fetch_assoc()){
                ?>
                <li><a href="products.php?brandId=<?php echo $resPro['proId'] ?>&catId=<?php echo $resCat['ID'] ?>"><i class="icon-chevron-right"></i><?php echo $resPro['producer'] ?></a></li>
                <?php }} ?>
            </ul>
        </li>
        <?php }} ?>
    </ul>
    <br />
   
</div>