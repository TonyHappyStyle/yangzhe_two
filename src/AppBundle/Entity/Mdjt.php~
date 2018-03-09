<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MdjtRepository")
 * @ORM\Table(name="mdjt",options={"comment":"志邦股份数据表"},indexes={@ORM\Index(name="date_idx",columns={"date"}),
 *              @ORM\Index(name="opening_ratio_idx",columns={"opening_ratio"}),
 *              @ORM\Index(name="pre_three_two_one_opening_date_idx",columns={"pre_count","pre_two_count","pre_three_count","count","opening_ratio","date"}),
 *              @ORM\Index(name="pre_two_one_opening_date_idx",columns={"pre_count","pre_two_count","count","opening_ratio","date"}),
 *              @ORM\Index(name="pre_three_two_opening_date_idx",columns={"pre_count","pre_two_count","pre_three_count","opening_ratio","date"})
 * })
 */
class Mdjt
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=20)
     */
    private $date;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $time;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $opening_price;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $ceiling_price;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $lower_price;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $closing_price;
    /**
     * @ORM\Column(type="integer",length=24)
     */
    private $volume;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $rose;
/**
     * @ORM\Column(type="string",length=12)
     */
    private $amplitude;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $opening_ratio;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $ceiling_to_opening;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $lower_to_opening;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $ceiling_ratio;
    /**
     * @ORM\Column(type="string",length=12)
     */
    private $lower_ratio;
    /**
     * @ORM\Column(type="integer",length=12)
     */
    private $count;
    /**
     * @ORM\Column(type="integer",length=12)
     */
    private $pre_count;
    /**
     * @ORM\Column(type="integer",length=12)
     */
    private $pre_two_count;
    /**
     * @ORM\Column(type="integer",length=12)
     */
    private $pre_three_count;

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
     * Set date
     *
     * @param string $date
     * @return Mdjt
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param string $time
     * @return Mdjt
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set opening_price
     *
     * @param string $openingPrice
     * @return Mdjt
     */
    public function setOpeningPrice($openingPrice)
    {
        $this->opening_price = $openingPrice;

        return $this;
    }

    /**
     * Get opening_price
     *
     * @return string 
     */
    public function getOpeningPrice()
    {
        return $this->opening_price;
    }

    /**
     * Set ceiling_price
     *
     * @param string $ceilingPrice
     * @return Mdjt
     */
    public function setCeilingPrice($ceilingPrice)
    {
        $this->ceiling_price = $ceilingPrice;

        return $this;
    }

    /**
     * Get ceiling_price
     *
     * @return string 
     */
    public function getCeilingPrice()
    {
        return $this->ceiling_price;
    }

    /**
     * Set lower_price
     *
     * @param string $lowerPrice
     * @return Mdjt
     */
    public function setLowerPrice($lowerPrice)
    {
        $this->lower_price = $lowerPrice;

        return $this;
    }

    /**
     * Get lower_price
     *
     * @return string 
     */
    public function getLowerPrice()
    {
        return $this->lower_price;
    }

    /**
     * Set closing_price
     *
     * @param string $closingPrice
     * @return Mdjt
     */
    public function setClosingPrice($closingPrice)
    {
        $this->closing_price = $closingPrice;

        return $this;
    }

    /**
     * Get closing_price
     *
     * @return string 
     */
    public function getClosingPrice()
    {
        return $this->closing_price;
    }

    /**
     * Set volume
     *
     * @param integer $volume
     * @return Mdjt
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return integer 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set rose
     *
     * @param string $rose
     * @return Mdjt
     */
    public function setRose($rose)
    {
        $this->rose = $rose;

        return $this;
    }

    /**
     * Get rose
     *
     * @return string 
     */
    public function getRose()
    {
        return $this->rose;
    }

    /**
     * Set amplitude
     *
     * @param string $amplitude
     * @return Mdjt
     */
    public function setAmplitude($amplitude)
    {
        $this->amplitude = $amplitude;

        return $this;
    }

    /**
     * Get amplitude
     *
     * @return string 
     */
    public function getAmplitude()
    {
        return $this->amplitude;
    }

    /**
     * Set opening_ratio
     *
     * @param string $openingRatio
     * @return Mdjt
     */
    public function setOpeningRatio($openingRatio)
    {
        $this->opening_ratio = $openingRatio;

        return $this;
    }

    /**
     * Get opening_ratio
     *
     * @return string 
     */
    public function getOpeningRatio()
    {
        return $this->opening_ratio;
    }

    /**
     * Set ceiling_to_opening
     *
     * @param string $ceilingToOpening
     * @return Mdjt
     */
    public function setCeilingToOpening($ceilingToOpening)
    {
        $this->ceiling_to_opening = $ceilingToOpening;

        return $this;
    }

    /**
     * Get ceiling_to_opening
     *
     * @return string 
     */
    public function getCeilingToOpening()
    {
        return $this->ceiling_to_opening;
    }

    /**
     * Set lower_to_opening
     *
     * @param string $lowerToOpening
     * @return Mdjt
     */
    public function setLowerToOpening($lowerToOpening)
    {
        $this->lower_to_opening = $lowerToOpening;

        return $this;
    }

    /**
     * Get lower_to_opening
     *
     * @return string 
     */
    public function getLowerToOpening()
    {
        return $this->lower_to_opening;
    }

    /**
     * Set ceiling_ratio
     *
     * @param string $ceilingRatio
     * @return Mdjt
     */
    public function setCeilingRatio($ceilingRatio)
    {
        $this->ceiling_ratio = $ceilingRatio;

        return $this;
    }

    /**
     * Get ceiling_ratio
     *
     * @return string 
     */
    public function getCeilingRatio()
    {
        return $this->ceiling_ratio;
    }

    /**
     * Set lower_ratio
     *
     * @param string $lowerRatio
     * @return Mdjt
     */
    public function setLowerRatio($lowerRatio)
    {
        $this->lower_ratio = $lowerRatio;

        return $this;
    }

    /**
     * Get lower_ratio
     *
     * @return string 
     */
    public function getLowerRatio()
    {
        return $this->lower_ratio;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return Mdjt
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set pre_count
     *
     * @param integer $preCount
     * @return Mdjt
     */
    public function setPreCount($preCount)
    {
        $this->pre_count = $preCount;

        return $this;
    }

    /**
     * Get pre_count
     *
     * @return integer 
     */
    public function getPreCount()
    {
        return $this->pre_count;
    }

    /**
     * Set pre_two_count
     *
     * @param integer $preTwoCount
     * @return Mdjt
     */
    public function setPreTwoCount($preTwoCount)
    {
        $this->pre_two_count = $preTwoCount;

        return $this;
    }

    /**
     * Get pre_two_count
     *
     * @return integer 
     */
    public function getPreTwoCount()
    {
        return $this->pre_two_count;
    }

    /**
     * Set pre_three_count
     *
     * @param integer $preThreeCount
     * @return Mdjt
     */
    public function setPreThreeCount($preThreeCount)
    {
        $this->pre_three_count = $preThreeCount;

        return $this;
    }

    /**
     * Get pre_three_count
     *
     * @return integer 
     */
    public function getPreThreeCount()
    {
        return $this->pre_three_count;
    }
}
