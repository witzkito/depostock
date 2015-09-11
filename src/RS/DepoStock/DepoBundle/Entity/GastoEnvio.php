<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GastoEnvio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\GastoEnvioRepository")
 */
class GastoEnvio
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
     * @ORM\Column(name="cantidad", type="decimal")
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gasto", inversedBy="envios")
     * @ORM\JoinColumn(name="gasto_id", referencedColumnName="id")
     */
    private $gasto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Envio", inversedBy="gastos")
     * @ORM\JoinColumn(name="envio_id", referencedColumnName="id")
     */
    private $envio;


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
     * Set cantidad
     *
     * @param string $cantidad
     * @return GastoEnvio
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set gasto
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Gasto $gasto
     * @return GastoEnvio
     */
    public function setGasto(\RS\DepoStock\DepoBundle\Entity\Gasto $gasto = null)
    {
        $this->gasto = $gasto;

        return $this;
    }

    /**
     * Get gasto
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Gasto 
     */
    public function getGasto()
    {
        return $this->gasto;
    }

    /**
     * Set envio
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Envio $envio
     * @return GastoEnvio
     */
    public function setEnvio(\RS\DepoStock\DepoBundle\Entity\Envio $envio = null)
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * Get envio
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Envio 
     */
    public function getEnvio()
    {
        return $this->envio;
    }
}
