<?php
require_once 'Entity.php';

class Movie extends Entity {

    public int $movie_id;
    public string $title;
    public int $duration;
    public string $description;
    public int $publication_year;
    public string $cover_image;
    /** FK for Movie */
    public int $previous_part;
    public float $price;
    public string $URL;

    public function __construct(int $id, string $title)
    {
        $this->movie_id = $id;
        $this->title = $title;
    }
}