<?php
/**
 * @author Alexander Stepanenko <alex.stepanenko@gmail.com>
 * @package templatemonster\healthchecks
 */

namespace templatemonster\healthchecks;

use Yii;

class Module extends \yii\base\Module
{
    public $checks = [];

    protected $healthCheks = [];
    protected $health;

    public function init()
    {
        parent::init();
        foreach ($this->checks as $key=>$val) {
            if (!is_callable($val)) {
                $key = $val;
                $val = [$this, 'check'.ucfirst($key)];
            }
            $this->addHealthCheck($key, $val);
        }
    }

    public function addHealthCheck($name, $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Health check must be callable');
        }
        $this->healthCheks[$name] = $callback;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function doHealthChecks()
    {
        $this->health = true;
        $result = [];
        foreach ($this->healthCheks as $name=>$callback) {
            $check = call_user_func($callback);
            if (!$check) {
                $this->health = false;
            }
            $result[$name] = $check;
        }
        return $result;
    }

    public function checkDb()
    {
        try {
            $connection = Yii::$app->db;
            $connection->open();
            if ($connection->pdo !== null) {
                return true;
            }
        } catch (\Exception $e) {
        }
        return false;
    }

    public function checkCache()
    {
        try {
            $cache = Yii::$app->cache;
            return $cache->set('healthcheck', 1);
        } catch (\Exception $e) {
        }
        return false;
    }
}
