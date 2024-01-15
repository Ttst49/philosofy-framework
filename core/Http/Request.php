<?php

namespace Core\Http;

use App\Entity\Pizza;
use Core\Attributes\Column;
use Core\Attributes\Id;
use Core\Attributes\TargetRepository;

class Request
{

    private array $globals;

    public function __construct(){
        $this->globals = $_SERVER;
    }

    public function getGlobals():array{
        return $this->globals;
    }

    public function resolvePropertiesFromEntity($className):array{

        $properties = [];

        $reflection = new \ReflectionClass($className);
        $namespaceName = $reflection->getNamespaceName();
        if (!str_contains($namespaceName, "Entity")){
            throw new \Exception("essaye plutot avec une entité");
        }

        $props = $reflection->getProperties();
        foreach ($props as $prop){
            $type = $prop->getType();
            $attributes = $prop->getAttributes(Column::class);

            foreach ($attributes as $attribute){
                if (!empty($attribute->getArguments())){
                    $properties[] = [
                        "name"=>$attribute->getArguments()["name"],
                        "type"=>$type->getName()
                    ];
                }
            }
        }

        /**
         * foreach ($properties as $property){
         * echo ("<br>");
         * echo($property["name"]);
         * echo ("<br>");
         * echo($property["type"]);
         * echo ("<br>");
         *}
         */

        return $properties;
        /**
         * $entity = ucfirst($className);
         * if(!class_exists("\App\Entity\.$entity")){
         * throw new \Exception("essaye plutot avec une entité");
         * }
         */
    }

    public function createObjectFromPropertiesArray(array $properties, $classname){

        $classnameUpperCase = ucfirst($classname);
        $object = new $classnameUpperCase();

        $ifStatementArray = [];
        foreach ($properties as $property){
            if (!empty($_POST[$property["name"]])
                &&  $_POST[$property["name"]] !== ""
                && htmlspecialchars($_POST[$property["name"]])){
                $type = $property["type"];
                switch ($type){
                    case "string":
                        $setter = "set".$property['name'];
                        $object->$setter($_POST[$property["name"]]);
                        var_dump($setter);

                    case "int" || "float":
                        if (ctype_digit($_POST[$property["name"]])){
                            $setter = "set".$property['name'];
                            $object->$setter($_POST[$property["name"]]);
                            var_dump($setter);
                        }
                        break;

                }

            }
        }
        var_dump($object);




    }

}