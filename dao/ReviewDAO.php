<?php

    require_once("models/Review.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    class ReviewDao implements ReviewDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildReview($data) {

            $reviewObject = new Review();
            
            $reviewObject->id = $data["id"];
            $reviewObject->id = $data["rating"];
            $reviewObject->id = $data["reviews"];
            $reviewObject->id = $data["users_id"];
            $reviewObject->id = $data["movies_id"];

            return $reviewObject;
        }
        
        public function create(Review $review) {
            
            $stmt = $this->conn->prepare("INSERT INTO reviews (rating, reviews, movies_id, users_id) 
            VALUES (:rating, :reviews, :movies_id, :users_id)");

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":reviews", $review->review);
            $stmt->bindParam(":movies_id", $review->movies_id);
            $stmt->bindParam(":users_id", $review->users_id);
           
            $stmt->execute();

            // Mensagem de sucesso depois de adicionar filme
            $this->message->setMessage("Crítica adicionada com sucesso!", "success", "index.php");
        }
        
        public function getMoviesReview($id) {

            $reviews = [];
            
            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                
                $reviewsData = $stmt->fetchAll();

                foreach($reviewsData as $review) {
                    
                    $reviews[] = $this->buildReview($review);
                }
            }

            return $reviews;
        }
        
        public function hasAlreadyReviewed($id, $userId) {}
        public function getRatings($id) {}
    
    }