<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Asserts;

class PropertySearch
{

/**
 * @var int|null
 */
    private $maxPrice;

    /**
     * @var int|null
     * @Asserts\Range(min=10, max=400)
     */
    private $minSurface;




    /**
     *
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     *
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }


    /**
     *
     * @param int|null $maxPrice
     * @return PropertySearch
     *
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     *
     * @param int|null $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}
