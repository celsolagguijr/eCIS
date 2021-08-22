<?php require_once('./layout/header.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo WEB_TITLE ?></title>
    <link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>imgs/logo.png">
    <?php require_once('./layout/plugins.php') ?>
</head>

<body>
    <header>
        <?php require_once('./layout/navigations.php') ?>
    </header>

    <section class="main-section mb-5">
        <div class="container-fluid" style="margin-top: 5.5rem">
            <div id="content"></div>
        </div>
        <div id="additional-forms"></div>
    </section>

    <footer>
        <?php require_once('./layout/footer.php') ?>
    </footer>
    <?php require_once('./layout/jsPlugins.php') ?>
</body>

</html>