<?php
/**
 * @author Alexander Stepanenko <alex.stepanenko@gmail.com>
 * @package indigerd\healthchecks
 */

namespace indigerd\healthchecks\models;

use yii\base\Model;

class HealthCheck extends Model
{
    public $name;
    public $passed;
}
