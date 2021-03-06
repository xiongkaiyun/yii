# 1.项目介绍
## 1.1.项目简单阐述
### 本次项目是一个类似京东商城的B2C模式商城。
#### 注：B2C(Business-to-Customer)，中文简称为“商对客”。“商对客”是电子商务的一种模式，也就是通常说的直接面向消费者销售产品和服务商业零售模式。

## 1.2.功能模块
### 系统划分：
- 前台 → 首页、商品展示、商品购买、订单管理、在线支付等模块
- 后台 → 品牌管理、商品管理、商品分类管理、订单管理、系统管理、会员管理等模块

## 1.3.开发环境和技术支持
- 开发环境：Windows
- 开发工具：PhpStorm+PHP5.6+Git+Apache
- 技术支持：Yii2.0+CDN+JQuery+sphinx
## 1.4.项目人员组成及周期成本
### 1.4.1.人员组成


级别 | 人数 |备注
---|--- | ---
项目经理及组长| 1|本人
开发人员|1 |本人
UI设计人员|1 |本人
前端开发人员|1 |本人
测试人员|1 |本人

### 1.4.2.项目周期成本

人数 | 周期 | 备注
---|--- | ---
1| 两周需求及设计|项目经理
1| 两周需求及设计|UI设计
4| 先来3个月|开发、测试人员

# 2.系统功能模块

## 2.1.需求
- [x] 品牌管理：
- [x] 文章管理：
- [x] 商品管理：
- [x] 商品分类管理：
- [x] 账号管理：
- [ ] 权限管理：
- [ ] 菜单管理：
- [ ] 订单管理：
## 2.2.流程
- 自动登录流程
- 购物车流程
- 订单流程
## 2.3.设计要点
1.系统前后台设计：
- 前台 www.yii2.com
- 后台 admin.yii2.com
- url地址进行美化

2.商品无限极分类设计

3.购物车设计

## 2.4.难点及解决方案

难点在于如何分析业务需求，考虑问题是否全面，逻辑处理优化等。解决方案：百度，找相关文档手册、博客论坛。

# 3.品牌管理模块
## 3.1.需求
- 品牌管理功能包括有列表展示、品牌添加、修改、删除功能。
- 品牌需要保存商标
- 品牌的删除使用逻辑删除
## 3.2.流程
敲代码。。。。。
## 3.3.难点及解决方案
1.composer安装
2.品牌商标图的保存使用webUPload插件+七牛云CDN存储
3.品牌删除使用逻辑删除，只需改变status属性，不用删除记录

# 4.文章管理模块

## 4.1.需求
- 文章表的增、删、改、查
- 文章分类表的增、删、改、查

## 4.2.设计要点
文章model和文章详情model建立1对1关系(has one)

## 4.3.难点及解决方案
1.分析字段并考虑到上下联系和健壮性
2.使用垂直分表

# 5.商品分类管理模块

## 5.1.需求
- 商品分类表的增、删、改、查
- 商品分类表展示使用无限极分类
- 列表可以折叠
- 左值 右值自动填写
- 修改时自动展开树状列表
- 修改时默认选中之前的选项
- 删除顶级分类时下面的子分类一起删除
## 5.2.设计要点
composer 安装zTree实现分类折叠
看zTree文档实现自动展开、默认选中、删除子类等效果
安装nested实现左值右值

## 5.3.难点及解决方案
1.zTree插件 进入添加或修改页面自动展开所有分类,利用js控制
2.nested删除节点要使用内置的deleteWithChildren()方法
3.健壮性的考虑

# 6.商品管理模块

## 6.1.需求

- 商品的增删改查
- 货号自动生成
- 商品详情
- 商品分类和品牌
- 多图上传
- 展示页面添加搜索栏

## 6.2.设计要点

- 货号可以自行输入,不输入则自动生成
- 商品详情、品牌、分类都要1对1
- 利用ueditor插件实现富文本编辑器
- 利用webuploader插件实现多图上传
- 图片存储在七牛云

## 6.3.难点及解决方案

- 货号生成: 0000."当天商品数量+1" 再截取后面5位
- Ueditor图片上传在本地 到时用 镜像存储解决
- 多图片回显,把图片地址以数组赋值给属性,多图上传个别失败,需要调整上传到的文件名(key)
- 列表货号搜索(难点)
- 删除顺序,要先删除关联的表的数据
- 多图片上传属性不能和数据库里有的字段一致

# 7.管理员模块

## 7.1.需求
- 管理员表的增删改查
- 管理员注册成功后自动登录
- 注销

## 7.2.设计要点

- 自动登录

## 7.3.难点及解决方案

- 修改配置里user组件用来实现用户的类Admin::className();
- 自己登录要实现接口

# 8.RBAC(待完成)














