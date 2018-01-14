<?php
/** @var $address frontend\models\Address */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>填写核对订单信息</title>
    <link rel="stylesheet" href="/layouts/style/base.css" type="text/css">
    <link rel="stylesheet" href="/layouts/style/global.css" type="text/css">
    <link rel="stylesheet" href="/layouts/style/header.css" type="text/css">
    <link rel="stylesheet" href="/layouts/style/fillin.css" type="text/css">
    <link rel="stylesheet" href="/layouts/style/footer.css" type="text/css">

    <script type="text/javascript" src="/layouts/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/layouts/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php
include_once Yii::getAlias("@app/views/common/nav.php");
//include_once "../../common/nav.php";
//echo Yii::getAlias("@app/views/common/nav.php")

?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="/user/index"><img src="/layouts/images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>
<form action="" method="post" id="order">

    <input type="hidden" name="_csrf-frontend" value="<?=Yii::$app->request->csrfToken?>">
    <!-- 主体部分 start -->
    <div class="fillin w990 bc mt15">
        <div class="fillin_hd">
            <h2>填写并核对订单信息</h2>
        </div>

        <div class="fillin_bd">
            <!-- 收货人信息  start-->
            <div class="address">
                <h3>收货人信息 </h3>
                <div class="address_info">

                    <?php foreach ($address as $address1): ?>
                        <p>

                            <input type="radio" value="<?=$address1->id?>" name="address_id" <?=$address1->status?"checked":""?>/><?php
                            echo $address1->name;
                            echo " ";
                            echo $address1->mobile;
                            echo " ";
                            echo $address1->province;
                            echo " ";
                            echo $address1->city;
                            echo " ";
                            echo $address1->county;
                            echo " ";
                            echo $address1->address;
                            echo " ";


                            ?>
                        </p>
                    <?php endforeach; ?>


                </div>


            </div>
            <!-- 收货人信息  end-->

            <!-- 配送方式 start -->
            <div class="delivery">
                <h3>送货方式</h3>


                <div class="delivery_selects">
                    <table width="600px">
                        <thead>
                        <tr>
                            <th class="col1">送货方式</th>
                            <th class="col2">运费</th>
                            <th class="col3">运费标准</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($deliverys as $delivery):?>
                            <tr class="<?=$delivery->status?"cur":""?>">
                                <td>
                                    <input type="radio" name="delivery" value="<?=$delivery->id?>" data-price=<?=$delivery->price?> <?=$delivery->status?"checked":""?> /><?=$delivery->name?>
                                </td>
                                <td>￥<?=$delivery->price?></td>
                                <td><?=$delivery->intro?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- 配送方式 end -->

            <!-- 支付方式  start-->
            <div class="pay">
                <h3>支付方式 </h3>


                <div class="pay_select">
                    <table>

                        <?php foreach (Yii::$app->params['payType'] as $k => $v): ?>
                            <tr class="<?= $k == 0 ? "cur" : "" ?>">
                                <td class="col1"><input type="radio" value="<?=$v['id']?>"
                                                        name="pay" <?= $k == 0 ? "checked" : "" ?> /><?= $v['name'] ?></td>
                                <td class="col2"><?= $v['intro'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>
            </div>
            <!-- 支付方式  end-->



            <!-- 商品清单 start -->
            <div class="goods">
                <h3>商品清单</h3>
                <table>
                    <thead>
                    <tr>
                        <th class="col1">商品</th>
                        <th class="col3">价格</th>
                        <th class="col4">数量</th>
                        <th class="col5">小计</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($goods as $good):?>
                        <tr>
                            <td class="col1"><a href="<?=\yii\helpers\Url::to(['goods/detail','id'=>$good['id']])?>"><img src="<?=$good['logo']?>" alt=""/></a> <strong><a
                                            href="<?=\yii\helpers\Url::to(['goods/detail','id'=>$good['id']])?>"><?=$good['name']?></a></strong></td>
                            <td class="col3">￥<?=$good['sale_price']?></td>
                            <td class="col4"> <?=$good['num']?></td>
                            <td class="col5"><span>￥<?=$good['sale_price']*$good['num']?></span></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul>
                                <li>
                                    <span>4 件商品，总商品金额：</span>
                                    <em>￥<span id="totalMoney"><?=$totalMoney?></span></em>
                                </li>
                                <li>
                                    <span>运费：</span>
                                    <em >￥<span id="yunFei"><?=$yunFei?></span></em>
                                </li>
                                <li>
                                    <span>应付总额：</span>
                                    <em>￥<span class="allMoney"><?=$allMoney?></span></em>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- 商品清单 end -->

        </div>

        <div class="fillin_ft">
            <a href="javascript:void(0)" onclick="submit()"><span class="TJ">提交订单</span></a>
            <p>应付总额：<strong>￥<span class="allMoney"><?=$allMoney?></span>元</strong></p>
        </div>

    </div>
</form>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。 ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/layouts/images/xin.png" alt=""/></a>
        <a href=""><img src="/layouts/images/kexin.jpg" alt=""/></a>
        <a href=""><img src="/layouts/images/police.jpg" alt=""/></a>
        <a href=""><img src="/layouts/images/beian.gif" alt=""/></a>
    </p>
</div>
<script type="text/javascript">
    function submit() {
        document.getElementById('order').submit();
    }

</script>

<!-- 底部版权 end -->
</body>
</html>
