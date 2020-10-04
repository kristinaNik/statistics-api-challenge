<?php

namespace App\DTO;

use App\Entity\Hotel;

class ReviewApiDto
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var Hotel
     */
    private $hoteId;

    /**
     * @var float
     */
    private $score;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * ReviewApiDto constructor.
     * @param int $id
     * @param Hotel $hoteId
     * @param float $score
     * @param string $comment
     * @param \DateTime $createdDate
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     */
    public function __construct(int $id, Hotel $hoteId, float $score, string $comment, \DateTime $createdDate, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->hoteId = $hoteId;
        $this->score = $score;
        $this->comment = $comment;
        $this->createdDate = $createdDate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param $id
     * @param $hoteId
     * @param $score
     * @param $comment
     * @param $createdDate
     * @param $createdAt
     * @param $updatedAt
     * @return ReviewApiDto
     */
    public static function create($id, $hoteId, $score, $comment, $createdDate, $createdAt, $updatedAt): ReviewApiDto
    {
        return new self($id, $hoteId, $score, $comment, $createdDate, $createdAt, $updatedAt);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Hotel
     */
    public function getHoteId(): Hotel
    {
        return $this->hoteId;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate(): \DateTime
    {
        return $this->createdDate;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

}