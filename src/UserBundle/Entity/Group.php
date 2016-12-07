<?php

declare(strict_types=1);

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="groups")
     */
    protected $users;

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }
}
