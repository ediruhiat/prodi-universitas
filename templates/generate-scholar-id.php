<?php
$temp = $_GET['gsid'];

$name = str_replace(" ", "%20", $temp);

$url = 'https://scholar.google.com/citations?view_op=search_authors&hl=en&mauthors='.$name.'&btnG=';

$var = file_get_contents($url);
$regex = "/user=[0-9A-Za-z_]+/";
preg_match($regex, $var, $gscholar_id, PREG_OFFSET_CAPTURE);
$gscholar_id = $gscholar_id[0];
$gscholar_id = substr($gscholar_id[0], 5);

if($gscholar_id == NULL){
    $gscholar_id = "Data tidak ditemukan.";
}

if (!is_null($gscholar_id)){
    ?>
    <form id="subform" method="post" action="admin.php?page=add_dosen">
        <input type="hidden" value="<?= $gscholar_id ?>" name="scholar-id" id="scholar-id">
    </form>

    <script type="text/javascript">
        document.getElementById('subform').submit();
    </script>

    <?php
}?>
