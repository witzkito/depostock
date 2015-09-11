<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\ProductoRepository")
 */
class Producto
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
     * @var string
     *
     * @ORM\Column(name="precio", type="decimal", nullable=true)
     */
    private $precio;

    /**
    * 
    * @ORM\OneToOne(targetEntity="FotoProducto" , inversedBy="producto", cascade={"remove", "persist"})
    * @ORM\JoinColumn(name="foto", referencedColumnName="id")
    */
    private $foto;
    
     /**
     * @ORM\OneToMany(targetEntity="IngresoProducto", mappedBy="producto")
     **/
    private $ingresos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="productos")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\OneToMany(targetEntity="PedidoProducto", mappedBy="producto")
     **/
    private $pedidos;
    
     /**
     * @ORM\OneToMany(targetEntity="EnvioProducto", mappedBy="producto")
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
     * @return Producto
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
     * Set precio
     *
     * @param string $precio
     * @return Producto
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
     * Constructor
     */
    public function __construct()
    {
        $this->depositos = new \Doctrine\Common\Collections\ArrayCollection();
    }
 
    /**
     * Set empresa
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Empresa $empresa
     * @return Producto
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

    /**
     * Set foto
     *
     * @param \RS\DepoStock\DepoBundle\Entity\FotoProducto $foto
     * @return Producto
     */
    public function setFoto( $foto = null)
    {
        foreach ($foto as $f){
            $file = new FotoProducto();
            $file->setFile($f);
            $this->foto = $file;
        }
        return $this;
    }

    /**
     * Get foto
     *
     * @return \RS\DepoStock\DepoBundle\Entity\FotoProducto 
     */
    public function getFoto()
    {
        if ($this->foto != null){
            return $this->foto->getFile();
        }else{
            return null;
        }
    }
    
    /**
     * Get FotoProducto
     * @return type
     */
    public function getFotoProducto()
    {
        return $this->foto;
    }
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Add ingresos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\IngresoProducto $ingresos
     * @return Producto
     */
    public function addIngreso(\RS\DepoStock\DepoBundle\Entity\IngresoProducto $ingresos)
    {
        $this->ingresos[] = $ingresos;

        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\IngresoProducto $ingresos
     */
    public function removeIngreso(\RS\DepoStock\DepoBundle\Entity\IngresoProducto $ingresos)
    {
        $this->ingresos->removeElement($ingresos);
    }

    /**
     * Get ingresos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngresos()
    {
        return $this->ingresos;
    }

    /**
     * Add pedidos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\PedidoProducto $pedidos
     * @return Producto
     */
    public function addPedido(\RS\DepoStock\DepoBundle\Entity\PedidoProducto $pedidos)
    {
        $pedidos->setPedido($this);
        $this->productos[] = $pedidos;
        return $this;
    }

    /**
     * Remove pedidos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\PedidoProducto $pedidos
     */
    public function removePedido(\RS\DepoStock\DepoBundle\Entity\PedidoProducto $pedidos)
    {
        $this->pedidos->removeElement($pedidos);
    }

    /**
     * Get pedidos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Add envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $envios
     * @return Producto
     */
    public function addEnvio(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $envios)
    {
        $this->envios[] = $envios;

        return $this;
    }

    /**
     * Remove envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $envios
     */
    public function removeEnvio(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $envios)
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
}
