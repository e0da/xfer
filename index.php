<?

ob_start();

$uploaded_file = $_FILES['uploaded_file'];

$share_path = 'share/';

$sanitized_name = sanitize_name($uploaded_file['name']);

if ($uploaded_file) {
  $target_path = $share_path.basename($sanitized_name);
  $success = move_uploaded_file($uploaded_file['tmp_name'], $target_path);
}

function sanitize_name($file_name) {
  $file_name = str_replace(' ', '_', $file_name);
  $file_name = preg_replace('/(\.php\d?)$/', '$1.txt', $file_name); //append .txt to .php, .php5, etc.
  return $file_name;
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
  if ($text == '.htaccess') return ''; // don't link .htaccess files
  $download = 'download/'.$text;
  $size = filesize($share_path.$file);
  $link = '<tr><td><a href="'.$download.'" title="Open file">'.$text.'</a></td><td style="text-align:center;width:20px"><a href="'.$download
    .'" title="Save file">&darr;</a></td><td style="text-align:right">'.hsize($size).'</td></tr>';
  return $link;
}

?><!doctype html>
    <title>xfer</title>
    <link rel="icon" type="image/png" href="xfer.png" />
    <link rel="stylesheet" href="style.css?<?= time() ?>" type="text/css" />
    <h1>xfer</h1>
    <?= $error; ?>
    <? if ( $success ) { ?>
    <p><strong><?= $sanitized_name ?></strong>: <?= $uploaded_file['size'] ?> bytes of type <?= $uploaded_file['type'] ?> uploaded
    <? } ?>
    <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <fieldset>
        <legend>Upload a file</legend>
        <p class="darkred">Caution: If you upload a file with the same name, your new file will overwrite the old one!
        <p><input name="uploaded_file" type="file" /> <input type="submit" value="Upload" />
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

