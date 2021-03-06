<?php

namespace WCS\CoavBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Airport
 *
 * @ORM\Table(name="terrain")
 * @ORM\Entity(repositoryClass="WCS\CoavBundle\Repository\TerrainRepository")
 */
class Airport
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=128)
     * @Assert\Type(
     *     type = "string",
     *     message = "{{ value}} is not a valid name."
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="icao", type="string", length=4)
     * @Assert\Type(
     *     type = "string",
     *     message = "{{ value }} is not a valid ICAO. ICAO must be 4 letters long."
     * )
     * @Assert\Length(
     *     min = 4,
     *     max = 4,
     *     exactMessage="ICAO should have exactly {{ limit }} characters."
     * )
     * @Assert\NotNull(
     *     message = "ICAO must be defined."
     * )
     */
    private $icao;

    /**
     * @var float
     * @ORM\Column(name="latitude", type="float")
     * @Assert\Type(
     *     type = "integer",
     *     message = "{{ value }} is not a valid latitude."
     * )
     */
    private $latitude;

    /**
     * @var float
     * @ORM\Column(name="longitude", type="float")
     * @Assert\Type(
     *     type = "integer",
     *     message = "{{ value }} is not a valid longitude."
     * )
     */
    private $longitude;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=128)
     *
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="city", type="string", length=128)
     * @Assert\NotNull(
     *     message = "Enter the airport's complete address."
     * )
     * @Assert\Type(
     *     type = "string",
     *     message = "{{ value }} is not a valid city name."
     * )
     */
    private $city;


    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=64)
     * @Assert\Type(
     *     type = "string",
     *     message = "The country is not a valid country name."
     * )
     * @Assert\NotNull(
     *     message = "Country must be defined."
     * )
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=Flight::class, mappedBy="departAirport")
     */
    private $departFlights;

    /**
     * @ORM\OneToMany(targetEntity=Flight::class, mappedBy="arrivalAirport")
     */
    private $arrivalFlights;

    public function __construct()
    {
        $this->arrivalFlights = new ArrayCollection();
        $this->departFlights = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Airport
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set icao
     *
     * @param string $icao
     *
     * @return Airport
     */
    public function setIcao($icao)
    {
        $this->icao = $icao;

        return $this;
    }

    /**
     * Get icao
     *
     * @return string
     */
    public function getIcao()
    {
        return $this->icao;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Airport
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Airport
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Airport
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Airport
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Airport
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add departFlight
     *
     * @param Flight $departFlight
     *
     * @return Airport
     */
    public function addDepartFLight(Flight $departFlight)
    {
        $this->departFlights[] = $departFlight;

        return $this;
    }

    /**
     * Remove departFlight
     *
     * @param Flight $departFlight
     */
    public function removeFlight(Flight $departFlight)
    {
        $this->departFlights->removeElement($departFlight);
    }

    /**
     * Get departFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFlights()
    {
        return $this->departFlights;
    }

    /**
     * Add arrivalFlight
     *
     * @param Flight $arrivalFlight
     *
     * @return Airport
     */
    public function addArrivalFlight(Flight $arrivalFlight)
    {
        $this->arrivalFlights[] = $arrivalFlight;

        return $this;
    }

    /**
     * Remove arrivalFlight
     *
     * @param Flight $arrivalFlight
     */
    public function removeArrivalFlight(Flight $arrivalFlight)
    {
        $this->arrivalFlights->removeElement($arrivalFlight);
    }

    /**
     * Get arrivalFlights
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArrivalFlights()
    {
        return $this->arrivalFlights;
    }


    /* Adding personnal methods */

    public function __toString()
    {
        return $this->name . "-" . $this->icao;
    }

}
