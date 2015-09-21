<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PedidoProducto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\PedidoProductoRepository")
 */
class EnvioProducto
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
     * @var integer
     *
     * @ORM\Column(name="confirmado", type="boolean", nullable = true)
     */
    private $confirmado;
    
    /**
     * @var decimal
     * @ORM\Column(name="precio", type="decimal", nullable = true)
     */
    private $precio;
    
    /**
     * @var decimal
     * @ORM\Column(name="pagado", type="decimal", nullable = true)
     */
    private $pagado;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="envios")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $producto;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="enviosProductos")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;
    
    /**
     * @ORM\ManyToOne(targetEntity="Envio", inversedBy="productos")
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
     * Set envio
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Envio $envio
     * @return EnvioProducto
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

    /**
     * Set cliente
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Cliente $cliente
     * @return EnvioProducto
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
     * Retorna verdadero si corresponde al deposito pasando un id de deposito
     * @param type $id
     * @return boolean
     */
    public function isDeposito($id)
    {
        if ($this->getEnvio()->getDeposito()->getId() == $id)
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return EnvioProducto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     * @return EnvioProducto
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean 
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }
    
    /**
     * Retorna el total del producto
     * @return type
     */
    public function getTotal()
    {
        return $this->getCantidad() * $this->getPrecio();
    }

    /**
     * Set pagado
     *
     * @param string $pagado
     * @return EnvioProducto
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return string 
     */
    public function getPagado()
    {
        return $this->pagado;
    }
}
