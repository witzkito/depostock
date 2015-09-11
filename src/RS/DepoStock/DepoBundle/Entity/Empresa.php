<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\EmpresaRepository")
 */
class Empresa
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
     * @ORM\OneToMany(targetEntity="Deposito", mappedBy="empresa")
     **/
    private $depositos;
    
    /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="empresa")
     **/
    private $clientes;
    
    /**
     * @ORM\OneToMany(targetEntity="Producto", mappedBy="empresa")
     **/
    private $productos;
    
    /**
     * @ORM\OneToMany(targetEntity="Transporte", mappedBy="empresa")
     **/
    private $transportes;
    
    /**
     * @ORM\OneToMany(targetEntity="Pedido", mappedBy="empresa")
     **/
    private $pedidos;


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
     * @return Empresa
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
        
    }

    

    /**
     * Add depositos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $depositos
     * @return Empresa
     */
    public function addDeposito(\RS\DepoStock\DepoBundle\Entity\Deposito $depositos)
    {
        $this->depositos[] = $depositos;

        return $this;
    }

    /**
     * Remove depositos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $depositos
     */
    public function removeDeposito(\RS\DepoStock\DepoBundle\Entity\Deposito $depositos)
    {
        $this->depositos->removeElement($depositos);
    }

    /**
     * Get depositos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepositos()
    {
        return $this->depositos;
    }
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Add clientes
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Cliente $clientes
     * @return Empresa
     */
    public function addCliente(\RS\DepoStock\DepoBundle\Entity\Cliente $clientes)
    {
        $this->clientes[] = $clientes;

        return $this;
    }

    /**
     * Remove clientes
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Cliente $clientes
     */
    public function removeCliente(\RS\DepoStock\DepoBundle\Entity\Cliente $clientes)
    {
        $this->clientes->removeElement($clientes);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClientes()
    {
        return $this->clientes;
    }

    /**
     * Add productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Producto $productos
     * @return Empresa
     */
    public function addProducto(\RS\DepoStock\DepoBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;

        return $this;
    }

    /**
     * Remove productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Producto $productos
     */
    public function removeProducto(\RS\DepoStock\DepoBundle\Entity\Producto $productos)
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
    
    public function getPedidos()
    {
        $retornar = array();
        foreach ($this->clientes as $cliente)
        {
            foreach ($cliente->getPedidosSinRealizar() as $pedido)
            {
                $retornar[$pedido->getPedido()->getId()] = $pedido->getPedido();
            }
        }
        return $retornar;
    }
    
    

    /**
     * Add transportes
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Transporte $transportes
     * @return Empresa
     */
    public function addTransporte(\RS\DepoStock\DepoBundle\Entity\Transporte $transportes)
    {
        $this->transportes[] = $transportes;

        return $this;
    }

    /**
     * Remove transportes
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Transporte $transportes
     */
    public function removeTransporte(\RS\DepoStock\DepoBundle\Entity\Transporte $transportes)
    {
        $this->transportes->removeElement($transportes);
    }

    /**
     * Get transportes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransportes()
    {
        return $this->transportes;
    }

    /**
     * Add pedidos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Pedido $pedidos
     * @return Empresa
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
}
