<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/comum.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Controll - IT</title>
</head>

<body>
    <form class="form-login" action="#" method="post">
        <div class="login-card card">
            <div class="card-header">
                <i class="icofont-architecture-alt mr-2"></i>
                <span class="font-weight-light">Controll - </span>
                <span class="font-weight-bold ml-1">IT</span>

                <i class="icofont-clock-time ml-2"></i>
            </div>
            <!-- Body-->
            <div class="card-body">
                <!--MENSAGENS-->
                <?php include(TEMPLATE_PATH . '/messages.php') ?>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?= $email ?>" class="form-control <?= isset($exception) && $exception->get('email') ? 'is-invalid' : '' ?>" placeholder="Email" autofocus>

                    <!-- Mostrar a mensagem de erro por baixo do email-->
                    <div class="invalid-feedback">
                        <?php echo (isset($exception) ?  ($exception->get('email')) : '') ?>
                    </div>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" autofocus>
                </div>
            </div>
            <!-- Footer-->
            <div class="card-footer">
                <button class="btn btn-primary">Entrar</button>
            </div>
        </div>
    </form>

</body>

</html>