<?php
/* Smarty version 3.1.30, created on 2017-10-31 17:33:13
  from "H:\IT\notes\php\phpbj\php18.0.1\template2\template.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59f84359648dc1_02303406',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7b0fb52aa91795781c9f3a02ebdeff2e3dd571e2' => 
    array (
      0 => 'H:\\IT\\notes\\php\\phpbj\\php18.0.1\\template2\\template.tpl',
      1 => 1509442389,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:foot.tpl' => 1,
  ),
),false)) {
function content_59f84359648dc1_02303406 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <h1><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h1>
    <div><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
