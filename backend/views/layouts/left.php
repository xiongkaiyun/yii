<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
                    <?php

                    if(Yii::$app->user->isGuest){
                        echo "<a href='/admin/login'>请登录</a>";
                    }else{
                        echo Yii::$app->user->identity->username;
                    }

                    ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
       <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?php
        $callback = function($menu){
            $data = json_decode($menu['data'], true);
            $items = $menu['children'];
            $return = [
                'label' => $menu['name'],
                'url' => [$menu['route']],
            ];
            //处理我们的配置
            if ($data) {
                //visible
                isset($data['visible']) && $return['visible'] = $data['visible'];
                //icon
                isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                //other attribute e.g. class...
                $return['options'] = $data;
            }
            //没配置图标的显示默认图标
            (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
            $items && $return['items'] = $items;
            return $return;
        };

        ?>




        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
//                'items'=>\backend\models\Mulu::menu(),
                'items'=>mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback),
               /* 'items' => [
                    ['label' => '后台管理系统', 'options' => ['class' => 'header']],

                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => '管理员',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
                            ['label' => '添加新管理员', 'icon' => 'circle-o', 'url' => ['admin/add'],],
                            ['label' => '管理员列表', 'icon' => 'circle-o', 'url' => ['admin/index'],],

                    ],],

                    [
                        'label' => '商品列表',
                        'icon' => 'gift',
                        'url' => '#',
                        'items' => [
                            ['label' => '展示商品信息', 'icon' => 'circle-o', 'url' => ['goods/index'],],
                            ['label' => '添加商品信息', 'icon' => 'circle-o', 'url' => ['goods/add'],],


                        ],],

                    [
                        'label' => '商品分类列表',
                        'icon' => 'gift',
                        'url' => '#',
                        'items' => [
                            ['label' => '展示商品分类', 'icon' => 'circle-o', 'url' => ['category/index'],],
                            ['label' => '添加商品分类', 'icon' => 'circle-o', 'url' => ['category/add'],],


                        ],],

                    [
                        'label' => '品牌列表',
                        'icon' => 'headphones',
                        'url' => '#',
                        'items' => [
                            ['label' => '展示品牌信息', 'icon' => 'circle-o', 'url' => ['brand/index'],],
                            ['label' => '添加品牌信息', 'icon' => 'circle-o', 'url' => ['brand/add'],],

                        ],],

                    [
                        'label' => '文章列表',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => '展示文章信息', 'icon' => 'circle-o', 'url' => ['article/index'],],
                            ['label' => '添加文章信息', 'icon' => 'circle-o', 'url' => ['article/add'],],


                        ],],

                    [
                        'label' => '文章分类列表',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => '展示文章分类', 'icon' => 'circle-o', 'url' => ['article-category/index'],],
                            ['label' => '添加文章分类', 'icon' => 'circle-o', 'url' => ['article-category/add'],],


                        ],],

              ],*/
            ]
        ) ?>

    </section>

</aside>
