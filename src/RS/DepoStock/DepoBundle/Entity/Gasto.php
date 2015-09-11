<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gastos
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Gasto
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;
    
    /**
     * @ORM\OneToMany(targetEntity="GastoEnvio", mappedBy="gasto", cascade={"persist", "remove"})
     **/
    private $envios;


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
     * Set nombre
     *
     * @param string $nombre
     * @return Gastos
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->envios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\GastoEnvio $envios
     * @return Gasto
     */
    public function addEnvio(\RS\DepoStock\DepoBundle\Entity\GastoEnvio $envios)
    {
        $this->envios[] = $envios;

        return $this;
    }

    /**
     * Remove envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\GastoEnvio $envios
     */
    public function removeEnvio(\RS\DepoStock\DepoBundle\Entity\GastoEnvio $envios)
    {
        $this->envios->removeElement($envios);
    }

    /**
     * Get envios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnvios()
    {
        return $this->envios;
    }
    
    public function __toString() {
        return $this->nombre;
    }
}
