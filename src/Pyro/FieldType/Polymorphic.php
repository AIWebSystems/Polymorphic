<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Relationship Field Type
 *
 * @author      Ryan Thompson - AI Web Systems, Inc.
 * @copyright   Copyright (c) 208 - 2014, AI Web Systems, Inc.
 * @license     http://www.aiwebsystems.com/
 * @link        http://www.aiwebsystems.com/
 */
class Polymorphic extends FieldTypeAbstract
{
    /**
     * Field type slug
     * @var string
     */
    public $field_type_slug = 'polymorphic';

    /**
     * DB column type
     * @var string
     */
    public $db_col_type = false;

    /**
     * Alternative processing
     * Because we use _id and _type columns
     * @var boolean
     */
    public $alt_process = true;

    /**
     * Custom parameters
     * @var array
     */
    public $custom_parameters = array(
        //'stream',
        );

    /**
     * Version
     * @var string
     */
    public $version = '1.0';

    /**
     * Author
     * @var  array
     */
    public $author = array(
        'name' => 'Ryan Thompson - AI Web Systems, Inc.',
        'url' => 'http://www.aiwebsystems.com/'
        );

    /**
     * Relation
     * @return object The relation object
     */
    public function relation()
    {
        return $this->morphTo();
    }

    /**
     * Output form input
     *
     * @access     public
     * @return    string
     */
    public function formInput()
    {
        return 'Polymorphic does not support direct entry.';
    }

    /**
     * Output the form input for frontend use
     * @return string 
     */
    public function publicFormInput()
    {
        return 'Polymorphic does not support direct entry.';
    }

    /**
     * Output filter input
     *
     * @access     public
     * @return    string
     */
    public function filterInput()
    {
        return 'Polymorphic does not support filters.';
    }

    /**
     * Pre Ouput
     * @return  mixed   null or string
     */
    public function stringOutput()
    {
        if ($entry = $this->getRelationResult()) {

            return $entry->getTitleColumnValue();
        }

        return null;
    }

    /**
     * Pre Ouput Plugin
     * @return array
     */
    public function pluginOutput()
    {
        if ($entry = $this->getRelationResult()) {
            return $entry->toArray();
        }

        return null;
    }

    /**
     * Pre Ouput Data
     * @return RelationClassModel
     */
    public function dataOutput()
    {
        if ($entry = $this->getRelationResult()) {
            return $entry;
        }

        return null;
    }

    /**
     * Overide the column name like field_slug_id
     * @param  Illuminate\Database\Schema   $schema
     * @return void
     */
    public function fieldAssignmentConstruct($schema)
    {
        $tableName = $this->getStream()->stream_prefix.$this->getStream()->stream_slug;

        $schema->table($tableName, function($table) {
            $table->integer($this->field->field_slug.'_id')->nullable();
            $table->string($this->field->field_slug.'_type')->nullable();
        });
    }
}
