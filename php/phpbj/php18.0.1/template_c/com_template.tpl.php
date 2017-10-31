<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $this->tpl_vars["title"]; ?></title>
</head>
<body>
  <table border="1" align="center" width="800">
    <?php foreach($this->tpl_vars["users"] as $this->tpl_vars["user"]) { ?>
      <tr>
        <?php foreach($this->tpl_vars["user"] as $this->tpl_vars["u"]) { ?>
          <?php if($this->tpl_vars["u"]== "meizi") { ?>
            <td bgcolor="green">
          <?php } elseif($this->tpl_vars["u"]== "admin") { ?>
            <td bgcolor="red">
          <?php } else { ?>
            <td>
          <?php } ?>
            <?php echo $this->tpl_vars["u"]; ?></td>
        <?php } ?>
      </tr>
    <?php } ?>
  </table>
    <h1><?php echo $this->tpl_vars["title"]; ?></h1>
    <div><?php echo $this->tpl_vars["content"]; ?></div>
  <footer>
    <center>########<?php echo $this->tpl_vars["title"]; ?>########</center>
  </footer>
</body>
</html>