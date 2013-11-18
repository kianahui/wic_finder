<html>
<head>
<title> <?php echo $pagetitle;?></title>
</head>

<?php foreach ($wic as $wic_site): ?>

    <h2><?php echo $wic_site['Agency'] ?></h2>
    <div id="main">
        <?php echo $wic_site['State'] ?>
    </div>
    <br>

<?php endforeach ?>
