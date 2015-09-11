<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedido
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\PedidoRepository")
 */
class Pedido
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
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="pedidos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    /**
     * @ORM\OneToMany(targetEntity="PedidoProducto", mappedBy="pedido", cascade={"persist", "remove"})
     **/
    private $productos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="pedidos")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;


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
     * @return Pedido
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
     * Constructor
     */
    public function __construct()
    {
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    

    /**
     * Set cliente
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Cliente $cliente
     * @return Pedido
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
     * Add productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\PedidoProducto $productos
     * @return Pedido
     */
    public function addProducto(\RS\DepoStock\DepoBundle\Entity\PedidoProducto $productos)
    {
        $productos->setPedido($this);
        $this->productos[] = $productos;
        
        return $this;
    }

    /**
     * Remove productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\PedidoProducto $productos
     */
    public function removeProducto(\RS\DepoStock\DepoBundle\Entity\PedidoProducto $productos)
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
    
    /**
     * Funcion que retorna verdadero si todos los productos de un pedido fueron
     * realizados
     * @return boolean
     */
    public function realizado()
    {
        foreach ($this->productos as $producto)
        {
            if (!$producto->getRealizado()){
                return false;
            }
        }
        return true;
    }

    /**
     * Set empresa
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Empresa $empresa
     * @return Pedido
     */
    public function setEmpresa(\RS\DepoStock\DepoBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
