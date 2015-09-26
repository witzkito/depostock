<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Envio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\EnvioRepository")
 */
class Envio
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
     * @ORM\ManyToOne(targetEntity="Transporte", inversedBy="envios")
     * @ORM\JoinColumn(name="transporte_id", referencedColumnName="id")
     **/
    private $transporte;

    /**
     * @ORM\OneToMany(targetEntity="EnvioProducto", mappedBy="envio", cascade={"persist", "remove"})
     **/
    private $productos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="envios")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
     **/
    private $deposito;
    
    /**
     * @ORM\OneToMany(targetEntity="GastoEnvio", mappedBy="envio", cascade={"persist", "remove"})
     **/
    private $gastos;

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
     * @return Envio
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
     * Set transporte
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Transporte $transporte
     * @return Envio
     */
    public function setTransporte(\RS\DepoStock\DepoBundle\Entity\Transporte $transporte = null)
    {
        $this->transporte = $transporte;

        return $this;
    }

    /**
     * Get transporte
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Transporte 
     */
    public function getTransporte()
    {
        return $this->transporte;
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
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $productos
     * @return Envio
     */
    public function addProducto(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $productos)
    {
        $this->productos[] = $productos;

        return $this;
    }

    /**
     * Remove productos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\EnvioProducto $productos
     */
    public function removeProducto(\RS\DepoStock\DepoBundle\Entity\EnvioProducto $productos)
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
     * Set deposito
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $deposito
     * @return Envio
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
     * Add gastos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\GastoEnvio $gastos
     * @return Envio
     */
    public function addGasto(\RS\DepoStock\DepoBundle\Entity\GastoEnvio $gastos)
    {
        $this->gastos[] = $gastos;

        return $this;
    }

    /**
     * Remove gastos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\GastoEnvio $gastos
     */
    public function removeGasto(\RS\DepoStock\DepoBundle\Entity\GastoEnvio $gastos)
    {
        $this->gastos->removeElement($gastos);
    }

    /**
     * Get gastos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGastos()
    {
        return $this->gastos;
    }
    
    public function __toString() {
        return $this->transporte . " - " . $this->fecha->format('d/m/Y H:i');
    }
    
    /**
     * Retorna verdadero si algunos de los productoEnvio esta completado
     * @return boolean
     */
    public function getCompletado() {
        foreach ($this->productos as $producto)
        {
            if ($producto->getConfirmado()){
                return true;
            }
        }
        return false;
    }
    
    
    /**
     * Devuelve el total en moneda del envio
     * @return type
     */
    public function getTotal() {
        $retornar = 0;
        foreach ($this->productos as $producto)
        {
            if ($producto->getConfirmado()){
                $retornar = $retornar + ($producto->getPagado());
            }
        }
        foreach ($this->gastos as $gasto)
        {
            $retornar = $retornar - $gasto->getCantidad();
        }
        return $retornar;
    }
    
    
    public function removeAllGastos()
    {
        $this->gastos = null;
    }
    
    /**
     * Funcion que retornar los clientes de un envio
     * @return array
     */
    public function getClientesEnvio()
    {
        $retornar = array();
        foreach ($this->productos as $producto)
        {
            $retornar[$producto->getCliente()->getId()] = $producto->getCliente();
        }
        return $retornar;
    }
}
