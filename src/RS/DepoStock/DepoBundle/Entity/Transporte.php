<?php

namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transporte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RS\DepoStock\DepoBundle\Entity\Repositorio\TransporteRepository")
 */
class Transporte
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
     * @ORM\Column(name="patente", type="string", length=10, nullable = true)
     */
    private $patente;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=50, nullable = true)
     */
    private $telefono;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom_empresa", type="string", length=255, nullable = true)
     */
    private $nombreEmpresa;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tel_empresa", type="string", length=50, nullable = true)
     */
    private $telefonoEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="transportes")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;
    
    /**
     * @ORM\OneToMany(targetEntity="Ingreso", mappedBy="transporte")
     **/
    private $ingresos;

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
     * @return Transporte
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
     * Set patente
     *
     * @param string $patente
     * @return Transporte
     */
    public function setPatente($patente)
    {
        $this->patente = $patente;

        return $this;
    }

    /**
     * Get patente
     *
     * @return string 
     */
    public function getPatente()
    {
        return $this->patente;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Transporte
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Transporte
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
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Set empresa
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Empresa $empresa
     * @return Transporte
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
     * Set nombreEmpresa
     *
     * @param string $nombreEmpresa
     * @return Transporte
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;

        return $this;
    }

    /**
     * Get nombreEmpresa
     *
     * @return string 
     */
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * Set telefonoEmpresa
     *
     * @param string $telefonoEmpresa
     * @return Transporte
     */
    public function setTelefonoEmpresa($telefonoEmpresa)
    {
        $this->telefonoEmpresa = $telefonoEmpresa;

        return $this;
    }

    /**
     * Get telefonoEmpresa
     *
     * @return string 
     */
    public function getTelefonoEmpresa()
    {
        return $this->telefonoEmpresa;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingresos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingresos
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Ingreso $ingresos
     * @return Transporte
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
}
