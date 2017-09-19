<?php
/*
INSTRUCTIONS PREALABLES :
1/ Donner la permission d'écriture sur le dossier de projet
2/ Personnaliser le chemin de la bddJSON dans le construct (l'arborescence se créera seule avec les droits nécessaires)
3/ Typer tous les paramètres $objet avec le nom de la classe y correspondant. L'objet utilisé doit avoir une méthode publique getClef()
4/rechercher toutes les méthodes de ##TEST## et les effacer
*/
class DatabaseJSON {
    protected $cheminFichierBD ;
    protected $listeFromBD ;

    public function __construct() {
        $this->cheminFichierBD = "admin/bdd.json";
        $this->listeFromBD = [] ;

        //si l'arborescence nécessaire n'existe pas, on la crée
        $arborescence = explode("/", $this->cheminFichierBD);
        $chemin = "" ;
        for ($i = 0 ; $i < count($arborescence) - 1 ; $i++) {
            if(!is_dir($chemin.$arborescence[$i])) {
                mkdir($chemin.$arborescence[$i], 0777);
            }
            $chemin.= $arborescence[$i]."/" ;
        }

        //si le fichier JSON pour la base de données n'existe pas, on le crée
        if (!file_exists($this->cheminFichierBD)) {
            $this->writeDB() ;
        }
    }

/*GETTER*/
    public function getListeFromBD() {
        return $this->listeFromBD ;
    }

/*deux fonctions vont se charger de lire et écrire dans le fichier json*/
    protected function readDB() {
        $fichierJSON = file_get_contents($this->cheminFichierBD) ;
        $this->listeFromBD = json_decode($fichierJSON, true) ;
    }

    protected function writeDB() {
        $fichierJSON = json_encode($this->listeFromBD, JSON_PRETTY_PRINT) ;
        file_put_contents($this->cheminFichierBD, $fichierJSON) ;
    }

/*CRUD*/
    public function createInDB($objet) {
        $this->readDB() ;
        $entree = $objet->getClef() ;
        $this->listeFromBD[$entree] = $objet ;
        $this->writeDB() ;
    }

    public function readInDB(string $attribut) {
        $this->readDB() ;
        return $this->listeFromBD[$attribut] ;
    }

    public function deleteFromDB(string $attribut) {
        $this->readDB() ;
        unset($this->listeFromBD[$attribut]) ;
        $this->writeDB() ;        
    }

    public function editInDB($objet) {
        $this->readDB() ;
        $entree = $objet->getClef() ;
        unset($this->listeFromBD[$entree]) ;
        $this->listeFromBD[$entree] = $objet ;
        $this->writeDB() ; 
    }
}