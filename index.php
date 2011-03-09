<?

ob_start();

$uploadedfile = $_FILES['uploadedfile'];

$share_path = 'share/';

if ($uploadedfile) {
  $target_path = $share_path.basename(str_replace(' ','_',$uploadedfile['name']));
  $success = move_uploaded_file($uploadedfile['tmp_name'], $target_path);
}

function hsize($size) {
  $mod = 1024;
  $units = explode(' ','B KB MB GB TB PB');
  for ($i = 0; $size > $mod; $i++)
    $size /= $mod;
  return round($size, 2) . $units[$i];
}

function link_file($file) {
  global $share_path;
  $text = basename($file);
  $href = 'share/'.$text;
  $download = 'download/'.$text;
  $size = filesize($share_path.$file);
  $link = '<tr><td><a href="'.$href.'" title="Open file">'.$text.'</a></td><td style="text-align:center;width:20px"><a href="'.$download
    .'" title="Save file">&darr;</a></td><td style="text-align:right">'.hsize($size).'</td></tr>';
  return $link;
}

?><!doctype html>
    <title>ITG uploader</title>
    <link rel="stylesheet" href="style.css?<?= time() ?>" type="text/css" />
    <h1>ITG uploader</h1>
    <?= $error; ?>
    <? if ( $success ) { ?>
    <p><strong><?= $uploadedfile['name'] ?></strong>: <?= $uploadedfile['size'] ?> bytes of type <?= $uploadedfile['type'] ?> uploaded
    <? } ?>
    <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <fieldset>
        <legend>Upload a file</legend>
        <p class="darkred">Caution: If you upload a file with the same name, your new file will overwrite the old one!
        <p><input name="uploadedfile" type="file" /> <input type="submit" value="Upload" />
      </fieldset>
    </form>

    <h2>All files</h2>
    <table>

<?
if ($handle = opendir($share_path)) {

  while (false !== ($file = readdir($handle))) $files[] = $file;

  asort($files);

  $files = array_slice($files,2);

  foreach ($files as $file) print link_file($file);
}
?>

    </table>
  </body>
</html>

