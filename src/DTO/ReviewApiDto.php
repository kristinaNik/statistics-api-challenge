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
    private $hotelId;

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
     * @param Hotel $hotelId
     * @param float $score
     * @param string $comment
     * @param \DateTime $createdDate
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     */
    public function __construct(int $id, Hotel $hotelId, float $score, string $comment, \DateTime $createdDate, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->hotelId = $hotelId;
        $this->score = $score;
        $this->comment = $comment;
        $this->createdDate = $createdDate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
    public function getHotelId(): Hotel
    {
        return $this->hotelId;
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