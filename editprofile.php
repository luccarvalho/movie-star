<?php

    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    
    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullName = $user->getFullName($userData);

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>user_process.php" method="POST">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">Altere seus dados no formulário abaixo:</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php

    require_once("templates/footer.php");

?>