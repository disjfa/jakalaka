<?php

declare(strict_types=1);

namespace Disjfa\PictureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="picture_elements")
 */
class Element implements JsonSerializable
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
     * @ORM\Column(name="width", type="string")
     */
    private $type;

    /**
     * @var array
     * @ORM\Column(name="styles", type="array")
     */
    private $styles;

    /**
     * @var Picture
     * @ORM\ManyToOne(targetEntity="Disjfa\PictureBundle\Entity\Picture", inversedBy="elements")
     */
    private $picture;

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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param Picture $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'styles' => $this->styles,
        ];
    }
}
