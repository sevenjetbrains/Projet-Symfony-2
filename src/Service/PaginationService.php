<?php
namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService{
    private $entityClass;
    private $limit=10;
    private $currentPage=1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;

    public function __construct(ObjectManager $manager,Environment $twig,RequestStack $request,$templatePath){
        $this->route=$request->getCurrentRequest()->attributes->get('_route');
        
        $this->manager=$manager;
        $this->twig=$twig;
        $this->templatePath=$templatePath;

    }
   public function display(){
      $this->twig->display($this->templatePath,[
       'page'=>$this->currentPage,
       'pages'=>$this->getPages(),
       'route'=>$this->route
       ]);
   } 
public function getPages(){

    if(empty($this->entityClass)){
        throw new \Exception("Vous n'aves pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre object PaginationService !");
    }
    // 1)Connaitre le total des enregistrements de la table
    $repo=$this->manager->getRepository($this->entityClass);
    $total=count($repo->findAll());
    // 2)Faire la division ,l'arrondi et le renvoyer
    $pages=ceil($total / $this->limit);
    return $pages;
}



    public function getData(){
        if(empty($this->entityClass)){
            throw new \Exception("Vous n'aves pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre object PaginationService !");
        }

        //1)clalculer l'offest
        $offset=$this->currentPage * $this->limit - $this->limit;
        //2) Demander au repository de trouver les éléments
        $repo=$this->manager->getRepository($this->entityClass);
        $data=$repo->findBy([],[],$this->limit,$offset);

        //3)Renvoyer les éléments en question
        return $data;
    }

  
    
    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set the value of entityClass
     *
     * @return  self
     */ 
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of currentPage
     */ 
    public function getPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */ 
    public function setPage($Page)
    {
        $this->currentPage = $Page;

        return $this;
    }

    /**
     * Get the value of route
     */ 
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set the value of route
     *
     * @return  self
     */ 
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get the value of templatePath
     */ 
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Set the value of templatePath
     *
     * @return  self
     */ 
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }
}











?>