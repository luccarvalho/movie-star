<?php

    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    
    $userDao = new UserDao($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

    $movieDao = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        $message->setMessage("O filme ou série não foi encontrado!", "error", "index.php");
    
    } else {
        
        $movie = $movieDao->findById($id);

        // Verifica se o filme existe
        if(!$movie) {

            $message->setMessage("O filme ou série não foi encontrado!", "error", "index.php");
        }
    
    }

?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $movie->title ?></h1>
                <p class="page-description">Altere os dados do filme ou série no formulário abaixo:</p>
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data"></form>
                <input type="hidden" name="type" value="update">
                <input type="hidden" name="id" value="<?= $movie->id ?>">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Digite o título do seu filme" value="<?= $movie->title ?>">
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="length">Duração:</label>
                    <input type="text" class="form-control" name="length" id="length" placeholder="Digite o tempo de duração do filme" value="<?= $movie->length ?>">
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Drama">Drama</option>
                        <option value="Romance">Romance</option>
                        <option value="Suspense">Suspense</option>
                        <option value="Terror">Terror</option>
                        <option value="Fantasia/Ficção">Fantasia/Ficção</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer">
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar filme">
            </div>
        </div>
    </div>
</div>

<?php

    require_once("templates/footer.php");

?>

