<?php

namespace JJSoft\SigesCore\EntityGenerator\Middleware;

use League\Tactician\Middleware;

/**
 * Sets the prefix and table name for the table creation
 * Class SetPrefixAndTableName
 * @package JJSoft\SigesCore\EntityGenerator\Middleware
 */
class SetPrefixAndTableName implements Middleware
{
    /**
     * @param object $command
     * @param callable $next
     *
     * @return mixed
     */
    public function execute($command, callable $next)
    {
        $command->prefix = $this->setPrefix($command);
        $command->table_name = $this->getTableName($command);
        return $next($command);
    }


    /**
     * Set the entity prefix
     * @param $command
     * @return mixed
     */
    protected function setPrefix($command)
    {
        if (empty($command->prefix)) {
            return $command->namespace;
        }
        return $command->prefix;
    }


    /**
     * set the entity table name
     * @param $command
     * @return string
     */
    protected function getTableName($command)
    {
        return $command->prefix.'_'.$command->slug;
    }
}
