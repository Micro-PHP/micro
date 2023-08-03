<!-- <?= $_message = sprintf('%s (%d %s)', $exceptionMessage, $statusCode, $statusText); ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title><?= $_message; ?></title>
    <link rel="icon" type="image/png" href="<?= $this->include('assets/images/favicon.png.base64'); ?>">
    <style><?= $this->include('assets/css/exception.css'); ?></style>
    <style><?= $this->include('assets/css/exception_full.css'); ?></style>
</head>
<body>
<script>
    document.body.classList.add('theme-light');
</script>

<header>
    <div class="container">
        <h1 class="logo">Micro Exception</h1>

        <div class="help-link">
            <a href="https://micro-php.github.io/docs/">
                <span class="icon"><?= $this->include('assets/images/icon-book.svg'); ?></span>
                <span class="hidden-xs-down">Micro Framework</span> Docs
            </a>
        </div>
    </div>
</header>

<?= $this->include('/views/exception.html.php', $context); ?>

<script>
    <?= $this->include('assets/js/exception.js'); ?>
</script>
</body>
</html>
<!-- <?= $_message; ?> -->
