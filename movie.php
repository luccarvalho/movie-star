<?php

    require_once("templates/header.php");
    
    // Verifica se o usuário está autenticado
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");

    // Pegar o id do filme
    $id = filter_input(INPUT_GET, "id");

    $movie;

    $movieDao = new MovieDAO($conn, $BASE_URL);

    if(empty($id)) {

        $message->setMessage("O filme ou série não foi encontrado!", "error", "index.php");
    
    } else {
        
        $movie = $movieDao->findById($id);

        // Verifica se o filme existe
        if(!$movie) {

            $message->setMessage("O filme ou série não foi encontrado!", "error", "index.php");
        }
    
    }

    // Checar se o filme tem imagem
    if($movie->image == "") {
        $movie->image = "movie_cover.jpg";
    }

    // Checar se o filme é do usuário
    $userOwnsMovie = false;

    if(!empty($userData)) {

        if($userData->id === $movie->users_id) {
            $userOwnsMovie = true;
        }
    }

    // Resgatar as revies do filme
?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Duração: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i> 9</span>
            </p>
            <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $movie->description ?></p>
        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>/img/movies/<?= $movie->image ?>')"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações:</h3>
        </div>
    </div>
</div>
<?php

    require_once("templates/footer.php");

?>