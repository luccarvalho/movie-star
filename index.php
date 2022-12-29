<?php

    require_once("templates/header.php");

    require_once("dao/MovieDAO.php");

    // DAO dos filmes
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $latestMovies = $movieDao->getLatestMovies();

    $actionMovies = [];

    $comedyMovies = [];

?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Filmes e Séries novas</h2>
    <p class="section-description">Veja as críticas dos últimos filmes e séries adicionados no MovieStar</p>
    <div class="movies-container">
        <?php foreach($latestMovies as $movie) : ?>
            <div class="card movie-card">
                <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>')"></div>
                <div class="card-body">
                    <p class="card-rating">
                        <i class="fas fa-star"></i>
                        <span class="rating">9</span>
                    </p>
                    <h5 class="card-title">
                        <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
                    </h5>
                    <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
                    <a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="btn btn-primary card-btn">Conhecer</a>
                </div>
            </div>
        <?php endforeach; ?>    
    </div>
    <h2 class="section-title">Ação</h2>
    <p class="section-description">Veja os melhores filmes e séries de ação</p>
    <div class="movies-container"></div>
    <h2 class="section-title">Comédia</h2>
    <p class="section-description">Veja os melhores filmes e séries de comédia</p>
    <div class="movies-container"></div>
</div>

<?php

require_once("templates/footer.php");

?>