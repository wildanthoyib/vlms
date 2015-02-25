<?php
$page_title = 'Manajemen user - Update';
ob_start();
?>
<form action="<?php echo site_url('/system/user/simpan'); ?>" method="post">
<fieldset>
<legend>Data User</legend>
<?php
if (isset($detail_user['id'])) {
?>
<input type="hidden" name="updateID" value="<?php echo $detail_user['id']; ?>" />
<?php
} else {
  $detail_user['username'] = '';
  $detail_user['realname'] = '';
  $detail_user['groups'] = array();
}
?>
<div class="row">
  <div class="col-md-5">
    <div class="form-group">
      <label class="control-label" for="userName">Username (login)</label>
      <input type="text" id="userName" name="userName" value="<?php echo $detail_user['username']; ?>" />
    </div>
    <div class="form-group">
      <label class="control-label" for="realName">Nama lengkap user</label>
      <input type="text" id="realName" name="realName" value="<?php echo $detail_user['realname']; ?>" />
    </div>
    <div class="form-group">
      <label class="control-label" for="passwd1">Password</label>
      <input type="password" id="passwd1" name="passwd1" />
    </div>
    <div class="form-group">
      <label class="control-label" for="passwd1">Konfirmasi Password</label>
      <input type="password" id="passwd2" name="passwd2" />
    </div>
  </div>

  <div class="col-md-5">
    <div class="form-group">
      <label class="control-label" for="tglUsul">Group</label>
      <?php
      if (!empty($detail_user['groups'])) {
        $groups = @unserialize($detail_user['groups']);
      }
      foreach ($groups as $grp) :
        $checked = '';
        if (is_array($groups) && in_array($grp, $groups)) {
          $checked = ' checked="checked"';
        }
        echo '<label class="checkbox"><input type="checkbox" name="groups[]" value="'.$grp.'"'.$checked.'> '.ucwords($grp).'</label>'."\n";
      endforeach;
      ?>
    </div>
  </div>
  
  <button type="submit" name="simpan" class="btn btn-primary">Simpan data user</button>

</div>
</fieldset>
</form>
<?php
$main_content = ob_get_clean();

require 'templates/default/main.tpl.php';
