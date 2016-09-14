<?php
namespace Disjfa\BuilderBundle\Entity;

use UserBundle\Entity\User;

/**
 * Class BuilderQuery
 * @package Disjfa\BuilderBundle\Entity
 */
class BuilderQuery
{
    /**
     * @var User
     */
    private $author;

    /**
     * @var boolean
     */
    private $preferred;

    /**
     * BuilderQuery constructor.
     * @param User $author
     */
    public function __construct(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return boolean
     */
    public function isPreferred()
    {
        return $this->preferred;
    }

    /**
     * @param boolean $preferred
     */
    public function setPreferred($preferred)
    {
        $this->preferred = $preferred;
    }
}