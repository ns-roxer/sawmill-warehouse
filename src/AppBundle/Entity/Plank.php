<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plank
 *
 * @ORM\Table(name="Plank")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PlankRepository")
 */
class Plank
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="Color")
     * @ORM\JoinColumn(name="color_id", referencedColumnName="id", nullable=false)
     */
    private $color;

    /**
     * @var Material
     *
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id", nullable=false)
     */
    private $material;

    /**
     * @var float
     *
     * @ORM\Column(name="length", type="float", nullable=false)
     * @Assert\Range(
     *     min = 0.1,
     *     minMessage = "Lowest supported value is {{ limit }}.",
     * );
     */
    private $length;

    /**
     * @var float
     *
     * @ORM\Column(name="height", type="float", nullable=false)
     * @Assert\Range(
     *     min = 0.1,
     *     minMessage = "Lowest supported value is {{ limit }}.",
     * );
     */
    private $height;

    /**
     * @var float
     *
     * @ORM\Column(name="width", type="float", nullable=false)
     * @Assert\Range(
     *     min = 0.1,
     *     minMessage = "Lowest supported value is {{ limit }}.",
     * );
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     * @Assert\Range(
     *     min = 0,
     *     minMessage = "Lowest supported value is {{ limit }}.",
     * );
     */
    private $quantity;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param Color $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param Material $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param float $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}

