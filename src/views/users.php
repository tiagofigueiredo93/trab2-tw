<main class="content">
    <?php
    renderTitle(
        'Lista dos funcionários',
        'Mantenha os dados dos funcionários atualizados',
        'icofont-users'
    );

    include(TEMPLATE_PATH . "/messages.php");
    ?>

    <a class="btn btn-lg btn-primary mb-3" href="save_user.php">Novo Funcionário</a>
    <table class="table table-border table-striped table-hover">
        <thead>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de admissão na empresa</th>
            <th>Data de saída da empresa</th>
            <th>Ações</th>

        </thead>

        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                    <td><?= $user->start_date ?></td>
                    <td><?= $user->end_date ?></td>

                    <td>
                        <!-- Quando clicado no botão é uma requisição do tipo get e passo como parâmetro o update e o valor do parametro é o ID do USER-->
                        <a href="save_user.php?update=<?= $user->id ?>" class="btn btn-warning rounded-circle mr-2">
                            <i class="icofont-edit"></i>
                        </a>
                        <!-- Quando clicado no botão é uma requisição do tipo get e passo como parâmetro o delete e o valor do parametro é o ID do USER-->
                        <a href="?delete=<?= $user->id ?>" class="btn btn-danger rounded-circle">
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>

</main>