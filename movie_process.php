<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    // Resgata o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    // Resgata dados do usuário
    $userData = $userDao->verifyToken();

    if($type === "create") {

        // Receber os dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        // Validação mínima de dados
        if(!empty($title) && !empty($description) && !empty($category)) {

            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie->users_id = $userData->id;

            // Upload de imagem do filme
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];

                // Pegando extensão do arquivo
                $ext = strtolower(substr($image["name"], -4));

                // Checagem de tipo de imagem
                if(in_array($image["type"], $imageTypes)) {

                    // Checar se o arquivo é jpg
                    if($ext == ".jpg") {

                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                    // Imagem é png
                    } else if($ext == ".png") {

                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }

                    // Gerando o nome da imagem
                    $imageName = $movie->imageGenerateName($ext);

                    imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                    $movie->image = $imageName;

                } else {
                
                    $message->setMessage("Tipo inválido de imagem, insira jpg ou png!", "error", "back");
                }

            }

            $movieDao->create($movie);

        } else {
            
            $message->setMessage("É necessário inserir ao menos o título, a descrição e a categoria!", "error", "back");
        }

    } else if($type === "delete") {

        // Recebe os dados do formulário
        $id = filter_input(INPUT_POST, "id");

        $movie = $movieDao->findById($id);

        if($movie) {

            // Verifica se o filme é do usuário
            if($movie->users_id === $userData->id) {
                
                $movieDao->destroy($movie->id);

            } else {
                
                $message->setMessage("Informações inválidas!", "error", "index.php");
            }

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    
    } else if($type === "update") {
        
        // Receber os dados dos inputs
        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");
        $id = filter_input(INPUT_POST, "id");

        $movieData = $movieDao->findById($id);

        // Verifica se o filme foi encontrado
        if($movieData) {
            
            // Verifica se o filme é do usuário
            if($movieData->users_id === $userData->id) {

                // Validação mínima de dados
                if(!empty($title) && !empty($description) && !empty($category)) {
                
                    // Edição do filme
                    $movieData->title = $title;
                    $movieData->description = $description;
                    $movieData->trailer = $trailer;
                    $movieData->category = $category;
                    $movieData->length = $length;

                    // Upload de imagem do filme
                    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                        $image = $_FILES["image"];
                        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];

                        // Pegando extensão do arquivo
                        $ext = strtolower(substr($image["name"], -4));

                        // Checagem de tipo de imagem
                        if(in_array($image["type"], $imageTypes)) {

                            // Checar se o arquivo é jpg
                            if($ext == ".jpg") {

                                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                            // Imagem é png
                            } else if($ext == ".png") {

                                $imageFile = imagecreatefrompng($image["tmp_name"]);
                            }

                            // Gerando o nome da imagem
                            $movie = new Movie();
                            
                            $imageName = $movie->imageGenerateName($ext);

                            imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                            $movieData->image = $imageName;

                        } else {
                        
                            $message->setMessage("Tipo inválido de imagem, insira jpg ou png!", "error", "back");
                        }

                    }

                    $movieDao->update($movieData);
                
                } else {

                    $message->setMessage("É necessário inserir ao menos o título, a descrição e a categoria!", "error", "back");
                }

            } else {
                
                $message->setMessage("Informações inválidas!", "error", "index.php");
            }
        
        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
        }
    
    } else {
        
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }