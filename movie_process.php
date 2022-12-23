<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);

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

            // Upload de imagem do filme
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];

                // Pegando extensão do arquivo
                $ext = strtolower(substr($image["name"], -4));

                // Checar se o arquivo é jpg
                if($ext == ".jpg") {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                // Imagem é png
                } else if($ext == ".png") {

                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $movie->imageGenerateName($ext);
            
        }

        } else {
            
            $message->setMessage("É necessário inserir ao menos o título, a descrição e a categoria!", "error", "back");
        }

    } else {
        
        $message->setMessage("Informações inválidas!", "error", "index.php");
    }