<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:17
 */

namespace w2w\Model;

use DateTime;

class Movie
{
    private $id;
    private $title;
    private $description;
    private $year;
    private $poster;
    private $category;
    private $reviewAdmin;
    private $rating;
    private $tags = [];
    private $directors = [];
    private $actors = [];

    /**
     * Movie constructor.
     * @param int $id
     * @param string $title
     * @param Category $category
     */
    public function __construct(int $id, string $title, Category $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
    }


    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     * @return Tag[]
     */
    public function addTag(Tag $tag)
    {
        if (!in_array($tag, $this->tags)) {
            array_push($this->tags, $tag);
        }
        return $this->tags;
    }

    /**
     * @param Tag $tag
     * @return Tag[]
     */
    public function removeTag(Tag $tag)
    {
        if ($key = array_search($tag, $this->tags, true)) {
            array_slice($this->tags, 1, $key);
        }
        return $this->tags;
    }


    /**
     * @return Artist[]
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * @param Artist $director
     * @return Artist[]
     */
    public function addDirector(Artist $director)
    {
        if (!in_array($director, $this->directors)){
            array_push($this->directors, $director);
        }
        return $this->directors;
    }

    /**
     * @param Artist $director
     * @return Artist[]
     */
    public function removeDirector(Artist $director)
    {
        if ($key = array_search($director, $this->directors, true)) {
            array_slice($this->directors, 1, $key);
        }
        return $this->directors;
    }

    /**
     * @return Artist[]
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * @param Artist $actor
     * @return Artist[]
     */
    public function addActor(Artist $actor)
    {
        if (!in_array($actor, $this->actors)){
            array_push($this->actors, $actor);
        }
        return $this->actors;
    }

    /**
     * @param Artist $actor
     * @return Artist[]
     */
    public function removeActor(Artist $actor)
    {
        if ($key = array_search($actor, $this->actors, true)) {
            array_slice($this->actors, 1, $key);
        }
        return $this->actors;
    }


    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Review
     */
    public function getReviewAdmin()
    {
        return $this->reviewAdmin;
    }

    /**
     * @param Review $reviewAdmin
     */
    public function setReviewAdmin(Review $reviewAdmin)
    {
        $this->reviewAdmin = $reviewAdmin;
    }

    /**
     * @return Rating
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param Rating $rating
     */
    public function setRating(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {


        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param DateTime $year
     */
    public function setYear(DateTime $year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param string $poster
     */
    public function setPoster(string $poster)
    {
        $this->poster = $poster;
    }

}