<?php

namespace Core\Serializer;

class Serializer
{
    public static function deserialize($toDeserialize, $type = null /**string $format*/){
        if ($type){
            if (class_exists($type)){
                $deserialized = json_decode(strtolower($toDeserialize));
                $entity = new $type;
                $classType = new \ReflectionClass($type);
                $methods = $classType->getMethods();
                foreach ($methods as $method){
                    if (strtolower(substr($method->getName(), 0, 3)) === "set"){
                        $tmpMeth = $method->getName();
                        $supposedProperty = substr(strtolower($method->getName()), 3);
                        $entity->$tmpMeth($deserialized->$supposedProperty);
                    }
                }
                return $entity;
            }else return "class does not exist";
        }else{
            return json_decode($toDeserialize, true);
        }
    }
}