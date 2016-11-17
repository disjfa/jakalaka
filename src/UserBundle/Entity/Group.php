<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

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