<?php

    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    // Receber id do usuário
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {
        
        if(!empty($userData)) {
            
            $id = $userData->id;
        
        } else {
            
            $message->setMessage("Usuário não encontrado!", "error", "index.php");
        }
    
    } else {
        
        $message->setMessage("Usuário não encontrado!", "error", "index.php");
    }

?>

<div id="main-container" class="container-fluid"></div>

<?php

    require_once("templates/footer.php");

?>