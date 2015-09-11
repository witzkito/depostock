<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingreso
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\IngresoRepository")
 */
class Ingreso
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
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="ingresos")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
     */
    private $deposito;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="ingresos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    /**
     * @ORM\OneToMany(targetEntity="IngresoProducto", mappedBy="ingreso", cascade={"persist", "remove"})
     **/
    private $productos;


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
     * @return Ingreso
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
     * Set deposito
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $deposito
     * @return Ingreso
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

    /**
     * Set cliente
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Cliente $cliente
     * @return Ingreso
     */
    public function setCliente(\RS\DepoStock\DepoBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\IngresoProducto $productos
     * @return Ingreso
     */
    public function addProducto(\RS\DepoStock\DepoBundle\Entity\IngresoProducto $productos)
    {
        $productos->setIngreso($this);
        $this->productos[] = $productos;

        return $this;
    }

    /**
     * Remove productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\IngresoProducto $productos
     */
    public function removeProducto(\RS\DepoStock\DepoBundle\Entity\IngresoProducto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }
    

}
