<button value="1" name="lang">lang1</button>
<button value="2" name="lang">lang2</button>

<?php
$lang = $_POST["lang"];
?>

<?= $dic["lang_".$lang] ?>
