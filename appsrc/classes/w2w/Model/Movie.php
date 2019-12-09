<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:17
 */

namespace w2w\Model;

use DateTime;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="movies")
 */
class Movie
{
    const TOSTRING_FORMAT = "Movie#%d (title='%s', description='%s', year=%d, poster='%s', category=[%s])";
    const DEFAULT_DATETIME_FORMAT = "Y-m-d H:i:s";

	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column
     */
    private $title;

    /**
     * @Column
     */
    private $description;

    /**
     * @Column(type="integer")
     */
    private $year;

    /**
     * @Column
     */
    private $poster;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Category::class) 
	 * @JoinColumn(name="fk_category_id", referencedColumnName="id")
	 */
    private $category;

    /**
     * @OneToMany(targetEntity="\w2w\Model\Review", mappedBy="movie")
     */
    protected $reviews;

	/**
	 * @OneToOne(targetEntity=\w2w\Model\Review::class) 
	 * @JoinColumn(name="fk_admin_review_id", referencedColumnName="id")
	 */
    private $adminReview;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Rating::class) 
	 * @JoinColumn(name="fk_rating_id", referencedColumnName="id")
	 */
    private $rating;
    
    
    /**
     * @ManyToMany(targetEntity=\w2w\Model\Tag::class)
     * @JoinTable(
     * 	name="movies_tags",
     *  joinColumns={
     *      @JoinColumn(name="fk_movie_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @JoinColumn(name="fk_tag_id", referencedColumnName="id")
     *  }
     * )
     */
    private $tags = [];
    
    /**
     * @ManyToMany(targetEntity=\w2w\Model\Artist::class)
     * @JoinTable(
     * 	name="movies_directors",
     *  joinColumns={
     *      @JoinColumn(name="fk_movie_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @JoinColumn(name="fk_artist_id", referencedColumnName="id")
     *  }
     * )
     */
    private $directors = [];

    /**
     * @ManyToMany(targetEntity=\w2w\Model\Artist::class)
     * @JoinTable(
     * 	name="movies_actors",
     *  joinColumns={
     *      @JoinColumn(name="fk_movie_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @JoinColumn(name="fk_artist_id", referencedColumnName="id")
     *  }
     * )
     */
    private $actors = [];

    /**
     * Movie constructor.
     * @param int $id
     * @param string $title
     * @param Category $category
     */
    public function __construct(int $id = null, string $title = null, string $description = null, int $year = null, string $poster = null, Category $category = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->year = $year;
        $this->poster = $poster;
        $this->category = $category;
		$this->reviews = new ArrayCollection();
		$this->tags = new ArrayCollection();
		$this->directors = new ArrayCollection();
		$this->actors = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->title, 
            $this->description, 
            $this->year, 
            $this->poster, 
            $this->category
        );
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
    public function setYear(int $year)
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
    public function getAdminReview()
    {
        return $this->adminReview;
    }

    /**
     * @param Review $reviewAdmin
     */
    public function setAdminReview(Review $adminReview)
    {
        $this->adminReview = $adminReview;
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

    public function getReviews()
    {
		return $this->reviews->toArray();
	}
    	
    public function addReview(Review $review)
    {
        if ($this->reviews->contains($review)) {
            return;
        }
        $this->reviews->add($review);
    }
    
    public function removeReview(Review $review)
    {
        if (! $this->reviews->contains($review)) {
            return;
        }
        $this->reviews->removeElement($review);
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags->toArray();
    }

    /**
     * @param Tag $tag
     * @return Tag[]
     */
    public function addTag(Tag $tag)
    {
        if ($this->tags->contains($tag)) {
            return;
        }
        $this->tags->add($tag);
        /*if (!in_array($tag, $this->tags)) {
            array_push($this->tags, $tag);
        }
        return $this->tags;*/
    }

    /**
     * @param Tag $tag
     * @return Tag[]
     */
    public function removeTag(Tag $tag)
    {
        if (! $this->tags->contains($tag)) {
            return;
        }
        $this->tags->removeElement($tag);
        /*if ($key = array_search($tag, $this->tags, true)) {
            array_slice($this->tags, 1, $key);
        }
        return $this->tags;*/
    }

    /**
     * @return Artist[]
     */
    public function getDirectors()
    {
        return $this->directors->toArray();
    }

    /**
     * @param Artist $director
     * @return Artist[]
     */
    public function addDirector(Artist $director)
    {
        if ($this->directors->contains($director)) {
            return;
        }
        $this->directors->add($director);
        /*if (!in_array($director, $this->directors)){
            array_push($this->directors, $director);
        }*/
        return $this->directors;
    }

    /**
     * @param Artist $director
     * @return Artist[]
     */
    public function removeDirector(Artist $director)
    {
        if (! $this->directors->contains($director)) {
            return;
        }
        $this->directors->removeElement($director);
        /*if ($key = array_search($director, $this->directors, true)) {
            array_slice($this->directors, 1, $key);
        }
        return $this->directors;*/
    }

    /**
     * @return Artist[]
     */
    public function getActors()
    {
        return $this->actors->toArray();
    }

    /**
     * @param Artist $actor
     * @return Artist[]
     */
    public function addActor(Artist $actor)
    {
        if ($this->actors->contains($actor)) {
            return;
        }
        $this->actors->add($actor);
        /*if (!in_array($actor, $this->actors)){
            array_push($this->actors, $actor);
        }
        return $this->actors;*/
    }

    /**
     * @param Artist $actor
     * @return Artist[]
     */
    public function removeActor(Artist $actor)
    {
        if (! $this->actors->contains($actor)) {
            return;
        }
        $this->actors->removeElement($actor);
        /*if ($key = array_search($actor, $this->actors, true)) {
            array_slice($this->actors, 1, $key);
        }
        return $this->actors;*/
    }

}
