<?php

//Para posteriormente utilizar em outros forms, etc
$errors = [];


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];

    //unset para mostrar a mensagem uma vez só
    unset($_SESSION['message']);
} else if ($exception) {
    $message = [
        'type' => 'error',
        'message' => $exception->getMessage()
    ];

    //Caso seja um ValidationException
    if (get_class($exception) === 'ValidationException') {

        //Guardar todos os erros na variável erros
        $errors = $exception->getErrors();
    }
}


$alertType = '';


if ($message['type'] === 'error') {
    $alertType = 'danger';
} else {
    $alertType = 'success';
}
?>



<?php if ($message) : ?>

    <div role="alert" class="my-3 alert alert-<?= $alertType ?>">

        <?= $message['message'] ?>
    </div>

<?php endif ?>