<?php
require_once 'Entity.php';

class Movie extends Entity {

    public int $movie_id = 0;
    public string $title = "";
    public int $duration = 0;
    public string $description = "";
    public int $publication_year = 0;
    public string $cover_image = "";
    public int $previous_part = 0;
    public float $price = 0;
    public string $URL = "";

    public function __construct()
    {
    }
}