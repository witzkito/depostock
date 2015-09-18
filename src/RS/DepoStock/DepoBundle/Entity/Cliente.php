<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\ClienteRepository")
 */
class Cliente
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
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=30, nullable=true)
     */
    private $telefono;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="clientes")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="cliente")
     **/
    private $pedidos;
    
    /**
     * @ORM\OneToMany(targetEntity="EnvioProducto", mappedBy="cliente")
     **/
    private $enviosProductos;


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
     * @return Cliente
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
     * Set localidad
     *
     * @param string $localidad
     * @return Cliente
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Cliente
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Cliente
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingresos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set empresa
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Empresa $empresa
     * @return Cliente
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
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Add pedidos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Pedido $pedidos
     * @return Cliente
     */
    public function addPedido(\RS\DepoStock\DepoBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos[] = $pedidos;

        return $this;
    }

    /**
     * Remove pedidos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Pedido $pedidos
     */
    public function removePedido(\RS\DepoStock\DepoBundle\Entity\Pedido $pedidos)
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
    
    public function getPedidosSinRealizar()
    {
        $retornar = array();
        foreach ($this->pedidos as $pedido)
        {
            foreach ($pedido->getProductos() as $pedprod)
            {
                if (!$pedprod->getRealizado())
                {
                    $retornar[$pedprod->getId()] = $pedprod;
                }
            }
        }
        return $retornar;
    }

    /**
     * Add enviosProductos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $enviosProductos
     * @return Cliente
     */
    public function addEnviosProducto(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $enviosProductos)
    {
        $this->enviosProductos[] = $enviosProductos;

        return $this;
    }

    /**
     * Remove enviosProductos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $enviosProductos
     */
    public function removeEnviosProducto(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $enviosProductos)
    {
        $this->enviosProductos->removeElement($enviosProductos);
    }

    /**
     * Get enviosProductos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnviosProductos()
    {
        return $this->enviosProductos;
    }
}
