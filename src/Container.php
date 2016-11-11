<?php namespace MacchiatoPHP\DI;

class Container
{
    protected $instances = [];
    protected $mappings = [];

    public function setInstance($class, $instance)
    {
        $this->instances[$class] = $instance;
    }

    public function mapInterface($interface, $class)
    {
        $this->mappings[$interface] = $class;
    }

    public function instantiate($class, ...$extraParams)
    {
        $reflector = new \ReflectionClass($class);

        try {

            return $this->findInstance($class);
        } catch (InstanceCacheException $e) {

            if (!$reflector->isInstantiable()) {

                $class = $this->findMapping($class);
                return $this->instantiate($class);
            }

            $constructor = $reflector->getConstructor();
            $paramsValues = [];

            if ($constructor) {

                $paramsValues = $this->getContructorParameters($constructor, $extraParams);
            }

            $instance = $reflector->newInstanceArgs($paramsValues);

            $this->instances[$reflector->getName()] = $instance;

            return $instance;
        }
    }

    protected function getContructorParameters(\ReflectionMethod $constructor, array &$extraParams): array
    {
        $paramsValues = [];
        $parameters = $constructor->getParameters();

        foreach ($parameters as $parameter) {

            if (!$parameter->isDefaultValueAvailable()) {

                $paramClass = $parameter->getClass();

                if (empty($extraParams) && $paramClass === null) {
                    throw new MissingParametersException();
                } else if (!empty($extraParams) && $paramClass === null) {
                    $paramsValues[] = array_shift($extraParams);
                } elseif (!empty($extraParams) && $paramClass->isInstance($extraParams[0])) {
                    $paramsValues[] = array_shift($extraParams);
                } else {
                    $paramsValues[] = $this->instantiate($paramClass->getName());
                }
                
            } elseif (!empty($extraParams)) {
                $paramsValues[] = array_shift($extraParams);
            } else {
                break;
            }
        }

        return $paramsValues;
    }

    protected function findMapping(string $interface)
    {
        if (!isset($this->mappings[$interface])) {

            throw new InterfaceMappingException();
        }

        return $this->mappings[$interface];
    }
    protected function findInstance(string $class)
    {
        if (!isset($this->instances[$class])) {

            throw new InstanceCacheException();
        }

        return $this->instances[$class];
    }
}
