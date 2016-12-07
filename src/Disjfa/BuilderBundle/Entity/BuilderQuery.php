<?php

declare(strict_types=1);

namespace Disjfa\BuilderBundle\Entity;

use UserBundle\Entity\User;

/**
 * Class BuilderQuery.
 */
class BuilderQuery
{
    /**
     * @var User
     */
    private $author;

    /**
     * @var bool
     */
    private $preferred;

    /**
     * BuilderQuery constructor.
     *
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
     * @return bool
     */
    public function isPreferred()
    {
        return $this->preferred;
    }

    /**
     * @param bool $preferred
     */
    public function setPreferred($preferred)
    {
        $this->preferred = $preferred;
    }
}
