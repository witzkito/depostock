<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deposito
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\DepositoRepository")
 */
class Deposito
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
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=10, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="depositos")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
     **/
    private $empresa;

    /**
     * @ORM\OneToMany(targetEntity="Ingreso", mappedBy="deposito")
     **/
    private $ingresos;
    
    /**
     * @ORM\OneToMany(targetEntity="Caja", mappedBy="deposito")
     **/
    private $cajas;
    
    /**
     * @ORM\OneToMany(targetEntity="Envio", mappedBy="deposito")
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
     * @return Deposito
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
     * Set calle
     *
     * @param string $calle
     * @return Deposito
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
     * @return Deposito
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
     * Set localidad
     *
     * @param string $localidad
     * @return Deposito
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
     * Set provincia
     *
     * @param string $provincia
     * @return Deposito
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Deposito
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->empresa = new \Doctrine\Common\Collections\ArrayCollection();
    }    

    /**
     * Set empresa
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Empresa $empresa
     * @return Deposito
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
        return $this->nombre . " - " . $this->empresa;
    }

    

    /**
     * Add ingresos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Ingreso $ingresos
     * @return Deposito
     */
    public function addIngreso(\RS\DepoStock\DepoBundle\Entity\Ingreso $ingresos)
    {
        $this->ingresos[] = $ingresos;

        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Ingreso $ingresos
     */
    public function removeIngreso(\RS\DepoStock\DepoBundle\Entity\Ingreso $ingresos)
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
     * Devuelve un array con el id como indice y el total de stock como valor
     * @return type
     */
    public function getStock()
    {
        $retornar = array();
        
        foreach ($this->ingresos as $ingreso)
        {
            foreach($ingreso->getProductos() as $prod){
                if (! isset($retornar[$prod->getProducto()->getId()])){
                    $retornar[$prod->getProducto()->getId()] = 0;
                }
                $retornar[$prod->getProducto()->getId()] = $retornar[$prod->getProducto()->getId()] + $prod->getCantidad();
            }
        }
        foreach ($this->envios as $envio)
        {
            foreach ($envio->getProductos() as $prod){
                $retornar[$prod->getProducto()->getId()] = $retornar[$prod->getProducto()->getId()] - $prod->getCantidad();
            }
        }
        return $retornar;
    }
    
    /**
     * Devuelve un producto pasandole un id
     * @param type $id
     * @return type
     */
    public function getProducto($id)
    {
        foreach ($this->ingresos as $ingreso)
        {
            foreach ($ingreso->getProductos() as $prod)
            {
                if ($prod->getProducto()->getId() == $id)
                {
                    return $prod->getProducto();
                }
            }
        }
        return null;
    }
    
    /**
     * Devuelve verdadero si existe el producto
     * @param type $producto
     * @return boolean
     */
    public function tieneProducto($producto)
    {
        foreach ($this->getStock() as $key => $stock)
        {
            if ($key == $producto->getProducto()->getId())
            {
                if ($producto->getCantidad() <= $stock){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Add envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Envio $envios
     * @return Deposito
     */
    public function addEnvio(\RS\DepoStock\DepoBundle\Entity\Envio $envios)
    {
        $this->envios[] = $envios;

        return $this;
    }

    /**
     * Remove envios
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Envio $envios
     */
    public function removeEnvio(\RS\DepoStock\DepoBundle\Entity\Envio $envios)
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

    /**
     * Add cajas
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Caja $cajas
     * @return Deposito
     */
    public function addCaja(\RS\DepoStock\DepoBundle\Entity\Caja $cajas)
    {
        $this->cajas[] = $cajas;

        return $this;
    }

    /**
     * Remove cajas
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Caja $cajas
     */
    public function removeCaja(\RS\DepoStock\DepoBundle\Entity\Caja $cajas)
    {
        $this->cajas->removeElement($cajas);
    }

    /**
     * Get cajas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCajas()
    {
        return $this->cajas;
    }
    
    /**
     * Funcion q' devuelve la cantidad total en la caja
     * @return type
     */
    public function totalCaja()
    {
        $retornar = 0;
        foreach ($this->cajas as $caja)
        {
            $retornar = $retornar + $caja->getIngreso();
            $retornar = $retornar - $caja->getEgreso();
        }
        return $retornar;
    }
}
