<?php

namespace Core;

use \PDO;
use \PDOException;

class DB
{
  private static $_instance = null;
  private $_pdo, $_query, $_error, $_result, $_count = 0, $_lastInsertID = null;

  private function __construct() // Обеспечивает создание единственного экземпляра подключения к базе данных.
  {
    try {
      $this->_pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  public static function getInstance() // Обеспечивает создание единственного экземпляра подключения к базе данных.
  {
    if (!isset(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  public function query($sql, $params = [], $class = false) // Метод для выполнения SQL-запросов с подготовленными данными.
  {
    $this->_error = false;
    if ($this->_query = $this->_pdo->prepare($sql)) {
      $x = 1;
      if (count($params)) {
        foreach ($params as $param) {
          $this->_query->bindValue($x, $param);
          $x++;
        }
      }
      if ($this->_query->execute()) {
        if ($class) {
          $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
        } else {
          $this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
        }
        $this->_count = $this->_query->rowCount();
        $this->_lastInsertID = $this->_pdo->lastInsertId();
      } else {
        $this->_error = true;
      }
    }
    return $this;
  }

  protected function _read($table, $params = [], $class) // Чтение данных из БД.
  {
    $conditionString = '';
    $bind = [];
    $order = '';
    $limit = '';

    if (isset($params['conditions'])) {
      if (is_array($params['conditions'])) {
        foreach ($params['conditions'] as $condition) {
          $conditionString .= ' ' . $condition . ' AND';
        }
        $conditionString = trim($conditionString);
        $conditionString = rtrim($conditionString, ' AND');
      } else {
        $conditionString = $params['conditions'];
      }
      if ($conditionString != '') {
        $conditionString = ' WHERE ' . $conditionString;
      }
    }

    if (array_key_exists('bind', $params)) {
      $bind = $params['bind'];
    }

    if (array_key_exists('order', $params)) {
      $order = ' ORDER BY ' . $params['order'];
    }

    if (array_key_exists('limit', $params)) {
      $limit = ' LIMIT ' . $params['limit'];
    }
    $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
    if ($this->query($sql, $bind, $class)) {
      if (!count($this->_result)) return false;
      return true;
    }
    return false;
  }

  public function find($table, $params = [], $class = false) // Используется для поиска записей в таблице.
  {
    if ($this->_read($table, $params, $class)) {
      return $this->results();
    }
    return false;
  }

  public function findFirst($table, $params = [], $class = false) // Используется для поиска первой записи в таблице с использованием предоставленных параметров.
  {
    if ($this->_read($table, $params, $class)) {
      return $this->first();
    }
    return false;
  }

  public function insert($table, $fields = []) // Используется для вставки новой записи в таблицу.
  {
    $fieldString = '';
    $valueString = '';
    $values = [];

    foreach ($fields as $field => $value) {
      $fieldString .= '`' . $field . '`,';
      $valueString .= '?,';
      $values[] = $value;
    }
    $fieldString = rtrim($fieldString, ',');
    $valueString = rtrim($valueString, ',');
    $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
    if (!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function update($table, $id, $fields = []) // Используется для обновления существующей записи в таблице.
  {
    $fieldString = '';
    $values = [];
    foreach ($fields as $field => $value) {
      $fieldString .= ' ' . $field . ' = ?,';
      $values[] = $value;
    }
    $fieldString = trim($fieldString);
    $fieldString = rtrim($fieldString, ',');
    $sql = "UPDATE {$table} SET {$fieldString} WHERE id = ?";
    $values[] = $id;
    if (!$this->query($sql, $values)->error()) {
      return true;
    }
    return false;
  }

  public function delete($table, $id) // Используется для удаления записи из таблицы.
  {
    $sql = "DELETE from {$table} WHERE id = ?";
    if (!$this->query($sql, [$id])->error()) {
      return true;
    }
    return false;
  }

  public function results() // Возвращает результаты последнего выполненного запроса.
  {
    return $this->_result;
  }

  public function first() // Возвращает первую запись результата или пустой массив, если результатов нет.
  {
    return (!empty($this->_result)) ? $this->_result[0] : [];
  }

  public function count() // Возвращает количество найденных записей.
  {
    return $this->_count;
  }

  public function lastID() // Возвращает ID последней вставленной записи.
  {
    return $this->_lastInsertID;
  }

  public function get_columns($table) // Получает информацию о столбцах таблицы.
  {
    return $this->query("SHOW COLUMNS FROM {$table}")->results();
  }

  public function error() // Проверяет наличие ошибок при выполнении предыдущего запроса.
  {
    return $this->_error;
  }
}
