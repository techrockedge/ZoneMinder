<?php
namespace ZM;
require_once('database.php');

$object_cache = array();

class ZM_Object {

  public function __construct($IdOrRow = NULL) {
    $class = get_class($this);

    $row = NULL;
    if ( $IdOrRow ) {
      if ( is_integer($IdOrRow) or ctype_digit($IdOrRow) ) {
        $table = $class::$table;
        $row = dbFetchOne("SELECT * FROM `$table` WHERE `Id`=?", NULL, array($IdOrRow));
        if ( !$row ) {
          Error("Unable to load $class record for Id=$IdOrRow");
        }
      } elseif ( is_array($IdOrRow) ) {
        $row = $IdOrRow;
      }

      if ( $row ) {
        global $object_cache;
        if ( ! isset($object_cache[$class]) ) {
          $object_cache[$class] = array();
        }
        $cache = &$object_cache[$class];

        foreach ($row as $k => $v) {
          $this->{$k} = $v;
        }
        $cache[$row['Id']] = $this;
      }
    } else {
      # Set defaults
      foreach ( $this->defaults as $k => $v ) $this->{$k} = $v;
    } # end if isset($IdOrRow)
  } # end function __construct

  public function __call($fn, array $args){
    if ( count($args) ) {
      $this->{$fn} = $args[0];
    }
    if ( array_key_exists($fn, $this) ) {
      return $this->{$fn};
    } else {
      if ( array_key_exists($fn, $this->defaults) ) {
        return $this->defaults{$fn};
      } else {
        $backTrace = debug_backtrace();
        Warning("Unknown function call Object->$fn from ".print_r($backTrace,true));
      }
    }
  }

  public static function _find($class, $parameters = null, $options = null ) {
    $table = $class::$table;
    $filters = array();
    $sql = "SELECT * FROM `$table` ";
    $values = array();

    if ( $parameters ) {
      $fields = array();
      $sql .= 'WHERE ';
      foreach ( $parameters as $field => $value ) {
        if ( $value == null ) {
          $fields[] = '`'.$field.'` IS NULL';
        } else if ( is_array($value) ) {
          $func = function(){return '?';};
          $fields[] = '`'.$field.'` IN ('.implode(',', array_map($func, $value)). ')';
          $values += $value;

        } else {
          $fields[] = '`'.$field.'`=?';
          $values[] = $value;
        }
      }
      $sql .= implode(' AND ', $fields );
    }
    if ( $options ) {
      if ( isset($options['order']) ) {
        $sql .= ' ORDER BY ' . $options['order'];
      }
      if ( isset($options['limit']) ) {
        if ( is_integer($options['limit']) or ctype_digit($options['limit']) ) {
          $sql .= ' LIMIT ' . $options['limit'];
        } else {
          Error('Invalid value for limit('.$options['limit'].') passed to '.get_class()."::find from ".print_r($backTrace,true));
          return array();
        }
      }
    }
    $rows = dbFetchAll($sql, NULL, $values);
    $results = array();
    if ( $rows ) {
      foreach ( $rows as $row ) {
        array_push($results , new $class($row));
      }
    }
    return $results;
  } # end public function _find()

  public static function _find_one($class, $parameters = array(), $options = array() ) {
    global $object_cache;
    if ( ! isset($object_cache[$class]) )
      $object_cache[$class] = array();
    $cache = &$object_cache[$class];
    if ( 
        ( count($parameters) == 1 ) and
        isset($parameters['Id']) and
        isset($cache[$parameters['Id']]) ) {
      return $cache[$parameters['Id']];
    }
    $options['limit'] = 1;
    $results = ZM_Object::_find($class, $parameters, $options);
    if ( ! sizeof($results) ) {
      return;
    }
    return $results[0];
  }

  public static function Objects_Indexed_By_Id($class) {
    $results = array();
    foreach ( ZM_Object::_find($class, null, array('order'=>'lower(Name)')) as $Object ) {
      $results[$Object->Id()] = $Object;
    }
    return $results;
  }

  public function to_json() {
    $json = array();
    foreach ($this->defaults as $key => $value) {
      if ( is_callable(array($this, $key)) ) {
        $json[$key] = $this->$key();
      } else if ( array_key_exists($key, $this) ) {
        $json[$key] = $this->{$key};
      } else {
        $json[$key] = $this->defaults{$key};
      }
    }
    return json_encode($json);
  }

  public function set($data) {
    foreach ( $data as $k => $v ) {
      if ( method_exists($this, $k) ) {
        $this->{$k}($v);
      } else {
        if ( is_array($v) ) {
# perhaps should turn into a comma-separated string
          $this->{$k} = implode(',', $v);
        } else if ( is_string($v) ) {
          if ( $v == '' and array_key_exists($k, $this->defaults) ) {
            $this->{$k} = $this->defaults[$k];
          } else {
            $this->{$k} = trim($v);
          }
        } else if ( is_integer($v) ) {
          $this->{$k} = $v;
        } else if ( is_bool($v) ) {
          $this->{$k} = $v;
        } else if ( is_null($v) ) {
          $this->{$k} = $v;
        } else {
          Error("Unknown type $k => $v of var " . gettype($v));
          $this->{$k} = $v;
        }
      } # end if method_exists
    } # end foreach $data as $k=>$v
  }

  public function changes( $new_values ) {
    $changes = array();
    foreach ( $new_values as $field => $value ) {

      if ( method_exists($this, $field) ) {
        $old_value = $this->$field();
        Logger::Debug("Checking method $field () ".print_r($old_value,true).' => ' . print_r($value,true));
        if ( is_array($old_value) ) {
          $diff = array_recursive_diff($old_value, $value);
          Logger::Debug("Checking method $field () diff is".print_r($diff,true));
          if ( count($diff) ) {
            $changes[$field] = $value;
          }
        } else if ( $this->$field() != $value ) {
          $changes[$field] = $value;
        }
      } else if ( array_key_exists($field, $this) ) {
        Logger::Debug("Checking field $field => ".$this->{$field} . ' ?= ' .$value);
        if ( $this->{$field} != $value ) {
          $changes[$field] = $value;
        }
      } else if ( array_key_exists($field, $this->defaults) ) {

        Logger::Debug("Checking default $field => ".$this->defaults[$field] . ' ' .$value);
        if ( $this->defaults[$field] != $value ) {
          $changes[$field] = $value;
        }
      }

        #if ( (!array_key_exists($field, $this)) or ( $this->{$field} != $new_values[$field] ) ) {
      #Logger::Debug("Checking default $field => $default_value changes becaause" . $new_values[$field].' != '.$new_values[$field]);
          #$changes[$field] = $new_values[$field];
        ##} else if  {
      #Logger::Debug("Checking default $field => $default_value changes becaause " . $new_values[$field].' != '.$new_values[$field]);
          ##array_push( $changes, [$field=>$defaults[$field]] );
        #}
      #} else {
        #Logger::Debug("Checking default $field => $default_value not in new_values");
      #}
    } # end foreach default 
    return $changes;
  } # end public function changes

  public function save($new_values = null) {
    $class = get_class($this);
    $table = $class::$table;

    if ( $new_values ) {
      Logger::Debug("New values" . print_r($new_values,true));
      $this->set($new_values);
    }

    if ( $this->Id() ) {
      $fields = array_keys($this->defaults);
      $sql = 'UPDATE '.$table.' SET '.implode(', ', array_map(function($field) {return '`'.$field.'`=?';}, $fields )) . ' WHERE Id=?';
      $values = array_map(function($field){return $this->{$field};}, $fields);
      $values[] = $this->{'Id'};
      if ( dbQuery($sql, $values) )
        return true;
    } else {
      $fields = $this->defaults;
      unset($fields['Id']);

      $sql = 'INSERT INTO '.$table.' ('.implode(', ', array_map(function($field) {return '`'.$field.'`';}, array_keys($fields))).') VALUES ('.implode(', ', array_map(function($field){return '?';}, array_values($fields))).')';
      $values = array_map(function($field){return $this->{$field};}, array_keys($fields));
      if ( dbQuery($sql, $values) ) {
        $this->{'Id'} = dbInsertId();
        return true;
      }
    }
    return false;
  } // end function save

  public function delete() {
    $class = get_class($this);
    $table = $class::$table;
    dbQuery("DELETE FROM $table WHERE Id=?", array($this->{'Id'}));
    if ( isset($object_cache[$class]) and isset($object_cache[$class][$this->{'Id'}]) )
      unset($object_cache[$class][$this->{'Id'}]);
  }

  public function lock() {
    $class = get_class($this);
    $table = $class::$table;
    $row = dbFetchOne("SELECT * FROM `$table` WHERE `Id`=?", NULL, array($this->Id()));
    if ( !$row ) {
      Error("Unable to lock $class record for Id=".$this->Id());
    }
  }
} # end class Object
?>
