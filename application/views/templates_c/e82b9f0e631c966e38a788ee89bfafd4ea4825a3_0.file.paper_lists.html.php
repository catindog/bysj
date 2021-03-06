<?php
/* Smarty version 3.1.33, created on 2019-06-08 11:51:00
  from 'D:\html\bysj\application\views\templates\student\paper_lists.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5cfba124b43d97_44975710',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e82b9f0e631c966e38a788ee89bfafd4ea4825a3' => 
    array (
      0 => 'D:\\html\\bysj\\application\\views\\templates\\student\\paper_lists.html',
      1 => 1559994409,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cfba124b43d97_44975710 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>学院管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="stylesheet" href="/public/static/css/font.css">
    <link rel="stylesheet" href="/public/static/css/xadmin.css">
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="/public/static/lib/layui/layui.js" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="/public/static/js/xadmin.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="/public/static/js/cookie.js"><?php echo '</script'; ?>
>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <?php echo '<script'; ?>
 src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"><?php echo '</script'; ?>
>
      <?php echo '<script'; ?>
 src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
    <![endif]-->
</head>

<body>
    <div class="x-nav">
        <span class="layui-breadcrumb">
            <a href="">材料提交管理</a>
            <a href="">论文管理</a>
            <a>
                <cite>列表</cite></a>
        </span>
        <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
            href="javascript:location.replace(location.href);" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
    </div>
    <div class="x-body">
        <div class="layui-row">
        </div>
            <?php if (empty($_smarty_tpl->tpl_vars['aPaper']->value)) {?>
        <xblock>
            <button class="layui-btn" onclick="x_admin_show('提交论文','/student/paper/add')"><i
                    class="layui-icon"></i>添加</button>
            <span class="x-right" style="line-height:40px"></span>
        </xblock>
            <?php }?> 
        <table class="layui-table x-admin">
            <thead>
                <tr>
                    <th>文件名</th>
                    <th>审核状态</th>
                    <th>审核意见</th>
                    <th>复审核教师</th>
                    <th>复审核状态</th>
                    <th>复审核意见</th>
                    <th>操作</th>
            </thead>
            <tbody>
                <?php if (!empty($_smarty_tpl->tpl_vars['aPaper']->value)) {?>
                    <tr>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['aPaper']->value['file_name'];?>

                        </td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 1) {?>未审核
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 2) {?>优
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 3) {?>良
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 4) {?>中
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 5) {?>及格
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 6) {?>不及格
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['aPaper']->value['sec_tea_id'];?>

                        </td>
                        <td>
                            <?php echo (($tmp = @$_smarty_tpl->tpl_vars['aPaper']->value['remark'])===null||$tmp==='' ? '无' : $tmp);?>

                        </td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 1) {?>未审核
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 2) {?>优
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 3) {?>良
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 4) {?>中
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 5) {?>及格
                            <?php } elseif ($_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 6) {?>不及格
                            <?php }?>
                        </td>
                        <td>
                            <?php echo (($tmp = @$_smarty_tpl->tpl_vars['aPaper']->value['sec_remark'])===null||$tmp==='' ? '无' : $tmp);?>

                        </td>
                        <td class="td-manage">
                            <?php if ($_smarty_tpl->tpl_vars['aPaper']->value['status'] == 6 || $_smarty_tpl->tpl_vars['aPaper']->value['sec_status'] == 6) {?>
                            <a title="编辑" onclick="x_admin_show('编辑','/student/paper/update?pap_id=<?php echo $_smarty_tpl->tpl_vars['aPaper']->value['pap_id'];?>
')" href="javascript:;">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <?php }?>
                            <a title="下载" href="/student/paper/download?act=do">
                                <i class="layui-icon">&#xe641;</i>
                            </a>
                        </td>
                    </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="20" style="text-align: center;">
                                暂无数据
                            </td>
                        </tr>
                        <?php }?> </tbody> </table> <div class="page">
                            <div>
                            </div>
    </div>

    </div>
</body>

</html><?php }
}
