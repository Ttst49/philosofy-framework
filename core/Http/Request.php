<?php

namespace Core\Http;

use Core\Attributes\Column;
use Core\Attributes\TargetRepository;
use Exception;
use ReflectionClass;
use ReflectionException;

class Request
{

    private array $globals;

    public function __construct(){
        $this->globals = $_SERVER;
    }

    public function getGlobals():array{
        return $this->globals;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function resolvePropertiesFromEntity($className):array{

        $properties = [];

        $reflection = new ReflectionClass($className);
        $namespaceName = $reflection->getNamespaceName();
        if (!str_contains($namespaceName, "Entity")){
            throw new Exception("essaye plutot avec une entité");
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

        // For showing every property with it type for debugging
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
    }

    /**
     * @throws ReflectionException
     */
    public function createObjectFromClassName($classname): object | null
    {

        $classnameUpperCase = ucfirst($classname);
        $object = new $classnameUpperCase();

        $properties = $this->resolvePropertiesFromEntity($classname);

        foreach ($properties as $property){
            if (!empty($_POST[$property["name"]])
                &&  $_POST[$property["name"]] !== ""
                && htmlspecialchars($_POST[$property["name"]])){
                $type = $property["type"];
                switch ($type){
                    case "string":
                        $setter = "set".$property['name'];
                        $object->$setter($_POST[$property["name"]]);
                        break;

                    case "int" || "float":
                        if (ctype_digit($_POST[$property["name"]])){
                            $setter = "set".$property['name'];
                            $object->$setter($_POST[$property["name"]]);
                        }
                        break;
                }
            }else{
                return null;
            }
        }
        return $object;
    }

}