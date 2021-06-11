<main class="content">
    <?php
    renderTitle(
        'Registar presenças',
        'Mantenha a presença consistente!',
        'icofont-check-alt'
    );
    include(TEMPLATE_PATH . "/messages.php");


    ?>

    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">As presenças marcadas hoje.</p>
        </div>
        <div class="card-body">
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 1: <?= $workinghours->time1 ?? 'Sem presença.' ?></span>
                <span class="record">Saida 1: <?= $workinghours->time2 ?? 'Sem presença.' ?></span>
            </div>
            <div class="d-flex m-5 justify-content-around">
                <span class="record">Entrada 2: <?= $workinghours->time3 ?? 'Sem presença.' ?></span>
                <span class="record">Saida 2: <?= $workinghours->time4 ?? 'Sem presença.' ?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="controllerInnout.php" class="btn-success btn-lg">
                <i class="icofont-check mr-1"></i>
                Marcar Presença
            </a>
        </div>
    </div>

    <form class="mt-5" action="controllerInnout.php" method="post">
        <div class="input-group no-border">
            <input type="text" name="forcedTime" class="form-control" placeholder="Informe a hora para simular a presença.">
            <button class="btn btn-danger ml-3">Simular presença</button>
        </div>


    </form>
</main>