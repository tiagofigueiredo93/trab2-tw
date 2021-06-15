<main class="content">
    <?php

    renderTitle(
        'Relatório Mensal',
        'Horas do funcionário',
        'icofont-ui-calendar'
    );
    ?>
    <div>
        <form class="mb-4" action="#" method="post">
            <div class="input-group">
                <!--VERIFICAR SE É ADMIN-->
                <?php if ($user->is_admin) : ?>
                    <select name="user" class="form-control" placeholder="Selecionar o funcionário...">
                        <option value="">Selecione o funcionário</option>
                        <?php
                        foreach ($users as $user) {
                            $selected = $user->id === $selectedUserId ? 'selected' : '';
                            echo "<option value='{$user->id}' {$selected}>{$user->name}</option>";
                        }
                        ?>
                    </select>
                <?php endif ?>
                <select name="period" class="form-control ml-2" placeholder="Selecionar o período...">
                    <?php
                    foreach ($periods as $key => $month) {
                        //caso a chave seja igual ao periodo selecionado, $select = selected, caso contrário colocar vazio
                        $selected = $key === $selectPeriod ? 'selected' : '';
                        echo "<option value='{$key}' {$selected}>{$month}</option>";
                    }
                    ?>
                </select>
                <button class="btn btn-primary ml-2">
                    <i class="icofont-search"></i>
                </button>
            </div>

        </form>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <th>Dia</th>
                <th>Entrada 1</th>
                <th>Saída 1</th>
                <th>Entrada 2</th>
                <th>Saída 2</th>
                <th>Saldo</th>
            </thead>
            <tbody>
                <?php
                foreach ($report as $registry) : ?>
                    <tr>
                        <td><?= formatDateWithLocale($registry->work_date, '%A, %d de %B de %Y') ?></td>
                        <td><?= $registry->time1 ?></td>
                        <td><?= $registry->time2 ?></td>
                        <td><?= $registry->time3 ?></td>
                        <td><?= $registry->time4 ?></td>
                        <td><?= $registry->getBalance() ?> </td>
                    </tr>
                <?php endforeach ?>

                <tr class="bg-primary text-white">
                    <td>Horas trabalhadas</td>
                    <td colspan="3"><?= $sumOfWorkedTime ?> </td>
                    <td>Saldo Mensal</td>
                    <td><?= $balance ?> </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>