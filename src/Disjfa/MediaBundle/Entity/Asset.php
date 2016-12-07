<?php

declare(strict_types=1);

namespace Disjfa\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="assets")
 */
class Asset
{
    /**
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
     * @var User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(name="original_name", type="string")
     */
    private $originalName;

    /**
     * @var string
     * @ORM\Column(name="mime_type", type="string")
     */
    private $mimeType;

    /**
     * @var int
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     * @ORM\Column(name="extension", type="string")
     */
    private $extension;

    /**
     * @var string
     * @ORM\Column(name="path", type="string")
     */
    private $path;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * Asset constructor.
     *
     * @param User $author
     */
    public function __construct(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
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
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        return in_array($this->extension, ['gif', 'jpg', 'jpeg', 'png'], true);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
