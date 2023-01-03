<?php

    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    
    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos filmes e séries que você enviou.</p>
    <div class="col-md-12" id="add-movie-container">
        <a href="<?= $BASE_URL ?>newmovie.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicionar Filme
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table"></table>
    </div>
</div>

<?php

    require_once("templates/footer.php");

?>