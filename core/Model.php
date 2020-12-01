<?php
namespace Core;

use stdClass;

class Model {
    protected $_db;
    protected $_table;
    protected $_modelName;
    protected $_softDelete = false;
    protected $_validates=true;
    protected $_validationErrors=[];
    public $id;

    public function __construct($table) {
        $this->_db = Database::getInstance();
        $this->_table = $table;
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_',' ', $this->_table)));
    }

    public function get_columns() {
        return $this->_db->get_columns($this->_table);
    }

    //TODO remove
    //  protected function _softDeleteParams($params){
    //    if($this->_softDelete){
    //      if(array_key_exists('conditions',$params)){
    //        if(is_array($params['conditions'])){
    //          $params['conditions'][] = "deleted != 1";
    //        } else {
    //          $params['conditions'] .= " AND deleted != 1";
    //        }
    //      } else {
    //        $params['conditions'] = "deleted != 1";
    //      }
    //    }
    //    return $params;
    //  }

    public function find($params = []) {
        //    $params = $this->_softDeleteParams($params);
        $resultsQuery = $this->_db->find($this->_table, $params,get_class($this));
        if(!$resultsQuery) return [];
        return $resultsQuery;
    }

    public function findFirst($params = []) {
        //    $params = $this->_softDeleteParams($params);
        $resultQuery = $this->_db->findFirst($this->_table, $params,get_class($this));
        return $resultQuery;
    }

    public function save() {
        $this->validator();
        if($this->_validates){
          $this->beforeSave();
          $fields = Helper::getObjectProperties($this);
          // determine whether to update or insert
          if(property_exists($this, 'id') && $this->id != '') {
            $save = $this->update($this->id, $fields);
            $this->afterSave();
            return $save;
          } else {
              $save = $this->insert($fields);
              $this->afterSave();
            return $save;
          }
        }
        return false;
    }

    public function findByUsername($username) {
        return $this->findFirst(['conditions'=> "username = ?", 'bind'=>[$username]]);
    }

    public function findByEmail($email) {
        return $this->findFirst(['conditions'=> "email = ?", 'bind'=>[$email]]);
    }

    public function findById($id) {
        return $this->findFirst(['conditions'=>"id = ?", 'bind' => [$id]]);
    }

    public function findByUserId($user_id) {
        return $this->findFirst(['conditions'=> "user_id = ?", 'bind'=>[$user_id]]);
    }

    public function userImages($user_id) {
        return $this->find(['conditions'=> "user_id = ?", 'order'=>"image_name DESC",'bind'=>[$user_id]]);
    }

    public function findImages() {
        //TODO get images and related data e.g author, timestamp
    }

    public function findComments($imageId) {
        $sql = "
            SELECT 
                c.user_id, 
                c.image_id, 
                c.content,
                c.date,
                u.username 
            FROM comments c, users u 
            WHERE c.image_id = ? AND u.id = c.user_id";
        $params = [$imageId];
        $this->query($sql, $params);
        return $this->_db->results();
    }

    public function getImageById($imageId = '') {
        //TODO join tables
        $sql = "
            SELECT
                i.id,
                i.user_id,
                i.image_data,
                i.date,
                u.username
            FROM images i, users u 
            WHERE i.id = ? AND u.id = i.user_id";
        $params = [$imageId];
        $this->query($sql, $params);
        return $this->_db->results()[0];
    }

    public function insert($fields) {
        if(empty($fields)) return false;
        if(array_key_exists('id', $fields)) unset($fields['id']);
        return $this->_db->insert($this->_table, $fields);
    }

    public function update($id, $fields) {
        if(empty($fields) || $id == '') return false;
        return $this->_db->update($this->_table, $id, $fields);
    }

    public function delete($id = '') {
        if($id == '' && $this->id == '') return false;
        $id = ($id == '')? $this->id : $id;
        return $this->_db->delete($this->_table, $id);
    }

    public function query($sql, $bind=[]) {
        return $this->_db->query($sql, $bind);
    }

    public function data() {
        $data = new stdClass();
        foreach(Helper::getObjectProperties($this) as $column => $value) {
          $data->column = $value;
        }
        return $data;
    }

    public function assign($params) {
        if(!empty($params)) {
            foreach($params as $key => $val) {
                if(property_exists($this,$key)) {
                $this->$key = $val;
                }
            }
            return true;
        }
        return false;
    }

    protected function populateObjData($result) {
        foreach($result as $key => $val) {
          $this->$key = $val;
        }
    }

    public function validator(){}

    public function runValidation($validator){
        $key = $validator->field;
        if(!$validator->success){
            $this->_validates = false;
            $this->_validationErrors[$key] = $validator->msg;
        }
    }

    public function getErrorMessages(){
        return $this->_validationErrors;
    }

    public function validationPassed(){
        return $this->_validates;
    }

    public function addErrorMessage($field,$msg){
        $this->_validates = false;
        $this->_validationErrors[$field] = $msg;
    }

    public function beforeSave(){}
    public function afterSave(){}

    public function isNew(){
        return (property_exists($this,'id') && !empty($this->id))? false : true;
    }
}
