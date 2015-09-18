<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caja
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\CajaRepository")
 */
class Caja
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="ingreso", type="decimal")
     */
    private $ingreso;

    /**
     * @var string
     *
     * @ORM\Column(name="egreso", type="decimal")
     */
    private $egreso;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="enlace", type="string", length=255, nullable = true)
     */
    private $enlace;
    
    /**
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="cajas")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
     **/
    private $deposito;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Caja
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set ingreso
     *
     * @param string $ingreso
     * @return Caja
     */
    public function setIngreso($ingreso)
    {
        $this->ingreso = $ingreso;

        return $this;
    }

    /**
     * Get ingreso
     *
     * @return string 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Set egreso
     *
     * @param string $egreso
     * @return Caja
     */
    public function setEgreso($egreso)
    {
        $this->egreso = $egreso;

        return $this;
    }

    /**
     * Get egreso
     *
     * @return string 
     */
    public function getEgreso()
    {
        return $this->egreso;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Caja
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set enlace
     *
     * @param string $enlace
     * @return Caja
     */
    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;

        return $this;
    }

    /**
     * Get enlace
     *
     * @return string 
     */
    public function getEnlace()
    {
        return $this->enlace;
    }

    /**
     * Set deposito
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $deposito
     * @return Caja
     */
    public function setDeposito(\RS\DepoStock\DepoBundle\Entity\Deposito $deposito = null)
    {
        $this->deposito = $deposito;

        return $this;
    }

    /**
     * Get deposito
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Deposito 
     */
    public function getDeposito()
    {
        return $this->deposito;
    }
}
