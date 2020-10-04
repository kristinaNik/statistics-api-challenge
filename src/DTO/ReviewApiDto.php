<?php


namespace App\DTO;


use App\Entity\Review;

class ReviewApiDto
{

    private $id;

    private $hoteId;

    private $score;

    private $comment;

    private $createdDate;

    public function __construct($id,$hoteId, $score, $comment, $createdDate)
    {
        $this->id = $id;
        $this->hoteId = $hoteId;
        $this->score = $score;
        $this->comment = $comment;
        $this->createdDate = $createdDate;
    }

    public static function create($id, $hoteId, $score, $comment, $createdDate)
    {
        return new self($id, $hoteId, $score, $comment, $createdDate);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHoteId()
    {
        return $this->hoteId;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

}