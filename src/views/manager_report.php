<main class="content">
    <?php
    renderTitle(
        'Relatório Geral',
        'Resumo das horas trabalhas dos funcionários',
        'icofont-chart-histogram'
    );
    ?>

    <div class="summary-boxes">
        <div class="summary-box bg-primary">
            <i class="icon icofont-users"></i>
            <p class="title">Quantidade de funcionários</p>
            <h3 class="value"><?= $activeUsersCount ?> Funcionários</h3>
        </div>
        <div class="summary-box bg-danger">
            <i class="icon icofont-patient-bed"></i>
            <p class="title">Faltas</p>
            <h3 class="value"><?= count($absentUsers) ?> Faltas</h3>
        </div>
        <div class="summary-box bg-success">
            <i class="icon icofont-sand-clock"></i>
            <p class="title">Horas trabalhadas neste mês</p>
            <h3 class="value"><?= $hoursInMonth ?> Horas</h3>
        </div>
    </div>
    <!-- Só mostar se existir funcionários a faltar-->

    <?php if (count($absentUsers) > 0) : ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Funcionários a faltar</h4>
                <p class="card-category mb-0">Relação dos funcionários que ainda não marcaram presença</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <th>Nome</th>
                    </thead>

                    <tbody>
                        <?php foreach ($absentUsers as $name) : ?>
                            <tr>
                                <td> <?= $name ?> </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</main>