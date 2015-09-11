<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidoProducto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\PedidoProductoRepository")
 */
class PedidoProducto
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
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @var type 
     * @ORM\Column(name="realizado", type="boolean", nullable=true)
     */
    private $realizado;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="pedidos")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $producto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="productos")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    private $pedido;


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
     * @param integer $cantidad
     * @return PedidoProducto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set producto
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Producto $producto
     * @return PedidoProducto
     */
    public function setProducto(\RS\DepoStock\DepoBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set pedido
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Pedido $pedido
     * @return PedidoProducto
     */
    public function setPedido(\RS\DepoStock\DepoBundle\Entity\Pedido $pedido = null)
    {
        $this->pedido = $pedido;
        return $this;
    }

    /**
     * Get pedido
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Pedido 
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set realizado
     *
     * @param boolean $realizado
     * @return PedidoProducto
     */
    public function setRealizado($realizado)
    {
        $this->realizado = $realizado;

        return $this;
    }

    /**
     * Get realizado
     *
     * @return boolean 
     */
    public function getRealizado()
    {
        return $this->realizado;
    }
    
    public function getTotal()
    {
        return $this->cantidad * $this->producto->getPrecio();
    }
    
}
