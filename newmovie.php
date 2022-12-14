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
    <h1>Corpo do site</h1>
</div>

<?php

require_once("templates/footer.php");

?>