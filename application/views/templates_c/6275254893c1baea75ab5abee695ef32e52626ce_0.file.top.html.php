<?php
/* Smarty version 3.1.33, created on 2019-06-05 09:21:13
  from 'D:\html\bysj\application\views\templates\student\top.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cf78989d46459_27962132',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6275254893c1baea75ab5abee695ef32e52626ce' => 
    array (
      0 => 'D:\\html\\bysj\\application\\views\\templates\\student\\top.html',
      1 => 1559726468,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cf78989d46459_27962132 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="/admin/home/index">毕业设计管理系统 v1</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo (($tmp = @$_SESSION['student']['name'])===null||$tmp==='' ? '(未知)' : $tmp);?>
</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <!-- <dd><a onclick="x_admin_show('个人信息','/admin/user/index')">个人信息</a></dd>
                <dd><a onclick="x_admin_show('切换帐号','/admin/user/change')">切换帐号</a></dd> -->
                <dd><a href="/student/user/logout">退出</a></dd>
            </dl>
        </li>
        <!-- <li class="layui-nav-item to-index"><a href="/teacher/user/index">导师前台</a></li> -->
        <!-- <li class="layui-nav-item to-index"><a href="/student/user/index">学生前台</a></li> -->
    </ul>

</div>
<!-- 顶部结束 --><?php }
}
