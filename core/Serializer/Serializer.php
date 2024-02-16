<?php

namespace Core\Serializer;

class Serializer
{
    public static function serialize($toSerialize)
    {
//        $serialized = json_encode($toSerialize);
        //status http
        //interfae sérializable
        //serializable sur entité direct
        echo (json_encode($toSerialize));
    }
}