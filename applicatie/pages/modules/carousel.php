<?php
require_once './models/Movie.php';
require_once './php/data/connection.php';
function createCarousel(string $genreName)
{
    $pdo = new pdo_mssql();
    $movies = $pdo->getMoviesByGenre($genreName);
    $carouselString = <<<HTML
    <div class="media-container">
        <div class="media-scroller">
    HTML;

    $chunked = array_chunk($movies, 4);
    $i = 1;
    foreach ($chunked as $chunk) {
        $carouselString .= createCarouselGroup($genreName, $chunk, $i);
        $i++;
    }

    $carouselString .= <<<HTML
            <div class="navigation-indicators">
    HTML;
    for ($d = 0; $d < $i; $d++) {
        $carouselString .= '<div></div>';
    }
    $carouselString .= <<<HTML
            </div>   
        </div>
    </div>
    HTML;
    echo ($carouselString);
}

function createCarouselGroup($genreName, $movies, int $i)
{
    $carouselGroup = <<<HTML
        <div class="media-group" id="$genreName-$i">
    HTML;

    if ($i > 1) {
        $prev = $i - 1;
        $carouselGroup .= <<<HTML
            <a class="previous" href="#$genreName-$prev">
                <svg>
                    <use href="#previous"></use>
                </svg>
            </a>
        HTML;
    }

    foreach ($movies as $m) {
        $carouselGroup .= createCarouselElement($m);
    }

    if ($i == 1) {
        $carouselGroup .= <<<HTML
                <a class="next" href="#$genreName-2" aria-label="next">
                    <svg>
                        <use href="#next"></use>
                    </svg>
                </a>
    
                <a class="next first-next" href="#$genreName-1" aria-label="next">
                    <svg>
                        <use href="#next"></use>
                    </svg>
                </a>
            </div>
        HTML;
    } else {
        $next = $i + 1;
        $carouselGroup .= <<<HTML
                <a class="next" href="#$genreName-$next" aria-label="next">
                    <svg>
                        <use href="#next"></use>
                    </svg>
                </a>
            </div>
        HTML;
    }

    return $carouselGroup;
}

function createCarouselElement($movie)
{
    $coverImage = $movie['cover_image'];
    $title = $movie['title'];
    $description = $movie['description'];
    $fid = $movie['movie_id'];
    $toEcho = <<<HTML
        <a class="media-element" href="/pages/filmdetail.php?fid=$fid">
            <img src="./assets/images/$coverImage"
                alt="">
            <div class="media-element-info">
                <h4>$title</h4>
                <p>$description</p>
            </div>
        </a>        
    HTML;

    return $toEcho;
}