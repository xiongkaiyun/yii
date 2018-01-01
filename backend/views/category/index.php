<h1>商品分类管理</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>

<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>分类名称</th>
        <th>父类id</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($cates as $cate):?>
        <tr class="cate_tr"
            data-tree="<?=$cate->tree?>"
            data-lft="<?=$cate->lft?>"
            data-rgt="<?=$cate->rgt?>"
        >
            <td><?=$cate->id?></td>
            <td><span class="glyphicon glyphicon-triangle-bottom"></span><?=$cate->nameText?></td>
            <td><?=$cate->parent_id?></td>
            <td><?=$cate->intro?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$cate->id])?>" class="btn btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$cate->id])?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
    <?php endforeach;?>

</table>

<?php
//定义JS
$js=<<<JS

$(".cate_tr").click(function() {
  var tr=$(this);
  //隐藏图标
  tr.find("span").toggleClass("glyphicon glyphicon-triangle-bottom")
  tr.find("span").toggleClass("glyphicon glyphicon-triangle-top")
  
  var lft_parent=tr.attr('data-lft');//选中的左值
  var rgt_parent=tr.attr('data-rgt');//选中的右值
  var tree_parent=tr.attr('data-tree');//选中的树
  
  console.log(lft_parent,rgt_parent,tree_parent);
  
  //当前类的左值 右值 树
  $(".cate_tr").each(function(k,v) {
      
      var lft=$(v).attr('data-lft');//当前的左值
      var rgt=$(v).attr('data-rgt');//当前的右值
      var tree=$(v).attr('data-tree');//当前的树
      
      console.log($(v).attr('data-lft'))
      
      //循环判断 当前的tr的左值大于选中的那个左值 右值小于选中的那个右值 树等于选中的树
      //js中除了+是往字符串转 ，其他统统都往数字转 lft rgt都是字符串
      if(tree==tree_parent && lft-lft_parent>0 && rgt-rgt_parent<0){
          
          //判断父类是不是展开状态
          if(tr.find('span').hasClass('glyphicon glyphicon-triangle-top')){
              $(v).find('span').removeClass('glyphicon glyphicon-triangle-bottom')
              $(v).find('span').addClass('glyphicon glyphicon-triangle-top')
              $(v).hide();
              
          }else{
              //当父类是闭合状态时
              $(v).find('span').removeClass('glyphicon glyphicon-triangle-top')
              $(v).find('span').addClass('glyphicon glyphicon-triangle-bottom')
              $(v).show();
              
          }
          
      }
      
    
  })
  
  console.dir(this);
  
});


JS;

//注入JS
$this->registerJs($js);



?>

