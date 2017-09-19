<?php
/*INFOS :
Utiliser ce modèle pour créer votre propre modèle de class d'objets à stocker dans la base de données en JSON, sachant qu'il sera absolument nécessaire de :
- implémenter la classe avec JsonSerializable sinon les attributs privés ne pourront être exportés en JSON
- avoir une fonction getClef pour pouvoir ensuite s'en servir dans le fichier JSON (ou adapter en fonction)
*/

class Objet implements JsonSerializable {
    //clef servant de clef d'entrée dans le fichier JSON
    protected $clef ;

    protected $attribut1 ;
    public $attribut2 ;

    //construction en donnant des valeurs d'attribut en paramètre
    public function __construct(string $clef, string $attr1, float $attr2) {
        $this->clef = $clef ;
        $this->attribut1 = $attr1 ;
        $this->attribut2 = $attr2 ;
    }

    public function getClef() {
        return $this->clef ;
    }

    //autres fonctions
    public function jsonSerialize() {
        return [
            "attribut1" => $this->attribut1,
            "attribut2" => $this->attribut2
        ] ;
    }


}