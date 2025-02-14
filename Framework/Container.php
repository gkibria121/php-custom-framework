<?php

declare(strict_types=1);



namespace Framework;

use Error;
use Exception;
use Framework\Exceptions\ContainerException;
use ReflectionClass;
use ReflectionNamedType;

class Container
{
    public function __construct(private array $definations) {}

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new Exception("Cannot create instance of $className. It is not instantiable");
        }
        $constractorClass = $reflectionClass->getConstructor();
        if (!$constractorClass) {
            return new $className;
        }
        $params =  $constractorClass->getParameters();

        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];
        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Faild to resolve  $className because {$name} type is missing.");
            }
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Faild to resolve  $className because invalid param name.");
            }

            $factory = $this->get($type->getName(), $this->definations);


            $dependencies[] = $factory();
        }

        return new $className(...$dependencies);
    }

    private function get(string $id, array $definations)
    {
        if (!array_key_exists($id, $definations)) {
            throw new ContainerException("Cannot find defination for $id");
        }
        return $definations[$id];
    }
}
