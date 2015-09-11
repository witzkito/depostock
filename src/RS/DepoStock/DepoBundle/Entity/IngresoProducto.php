<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IngresoProducto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\IngresoProductoRepository")
 */
class IngresoProducto
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
     * @ORM\ManyToOne(targetEntity="Ingreso", inversedBy="productos")
     * @ORM\JoinColumn(name="ingreso_id", referencedColumnName="id")
     */
    private $ingreso;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="ingresos")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    private $producto;


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
     * @return IngresoProducto
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
     * Set ingreso
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Ingreso $ingreso
     * @return IngresoProducto
     */
    public function setIngreso(\RS\DepoStock\DepoBundle\Entity\Ingreso $ingreso = null)
    {
        $this->ingreso = $ingreso;

        return $this;
    }

    /**
     * Get ingreso
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Ingreso 
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Set producto
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Producto $producto
     * @return IngresoProducto
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
     * Retorna verdadero si corresponde al deposito pasando un id de deposito
     * @param type $id
     * @return boolean
     */
    public function isDeposito($id)
    {
        if ($this->getIngreso()->getDeposito()->getId() == $id)
        {
            return true;
        }else{
            return false;
        }
    }
}
