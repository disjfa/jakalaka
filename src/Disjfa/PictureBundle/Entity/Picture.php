<?php

namespace Disjfa\PictureBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pictures")
 */
class Picture implements JsonSerializable
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="width", type="integer", nullable=false)
     */
    private $width;

    /**
     * @var string
     * @ORM\Column(name="height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $author;

    /**
     * @var Element[]
     * @ORM\OneToMany(targetEntity="Disjfa\PictureBundle\Entity\Element", mappedBy="picture", cascade={"persist"})
     */
    private $elements;

    /**
     * Picture constructor.
     * @param User $author
     */
    public function __construct(User $author)
    {
        $this->author = $author;
        $this->elements = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param integer $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @param Element $element
     */
    public function addElement(Element $element)
    {
        $element->setPicture($this);
    }

    /**
     * @return Element[]|ArrayCollection
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param Element[] $elements
     */
    public function setElements($elements)
    {
        foreach ($elements as $element) {
            if(null === $element->getPicture()) {
                $element->setPicture($this);
            }
        }
        $this->elements = $elements;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $elements = [];
        foreach ($this->elements as $element) {
            $elements[] = $element->jsonSerialize();
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'width' => $this->width,
            'height' => $this->height,
            'elements' => $elements,
        ];
    }
}