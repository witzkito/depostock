<?php
namespace RS\DepoStock\DepoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Sonata\UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class UsuarioDeposito
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Application\Sonata\UserBundle\Entity\User", inversedBy="depositos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $usuario;
    
    /**
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="usuarios")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
     **/
    private $deposito;

    public function __construct()
    {
       
    }

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
     * Set usuario
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Application/SonataUserBundle/User $usuario
     * @return UsuarioDeposito
     */
    public function setUsuario($usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \RS\DepoStock\DepoBundle\Entity\Application/SonataUserBundle/User 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set deposito
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Deposito $deposito
     * @return UsuarioDeposito
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
    
}
