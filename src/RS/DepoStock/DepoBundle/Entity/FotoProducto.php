<?php 
namespace RS\DepoStock\DepoBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 */
class FotoProducto
{
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $extension;
    
     /**
     * @Assert\File
     */
    private $file;
    
    /**
     * @ORM\OneToOne(targetEntity="Producto", mappedBy="foto")
     **/
    private $producto;
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Archivo
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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
    
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        $this->setExtension($this->getFile()->guessClientExtension());
        $nombre= $this->getProducto()->getId() . "-".$this->slug($this->getFile()->getClientOriginalName());
        
        $this->getFile()->move(
            $this->getUploadRootDir(),$nombre
            
        );
        // set the path property to the filename where you've saved the file
        $this->path = $nombre;

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
    
   
    private function slug($nombre)
    {
        $nombrestr = str_replace(' ', '-', $nombre); // Replaces all spaces with hyphens.
        return $nombrestr;

    }

        public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }
    
    public function getDirectPath()
    {
        return null === $this->path
             ? NULL
             : '/'.$this->getUploadDir().'/'.$this->path;
             
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/fotos';
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Archivo
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    
        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }
    
     public function removeUpload()
    {
        unlink($this->getAbsolutePath());
    } 

    

    /**
     * Set producto
     *
     * @param \RS\DepoStock\DepoBundle\Entity\Producto $producto
     * @return FotoProducto
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
}
