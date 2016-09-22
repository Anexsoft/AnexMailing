<?php
namespace App\Models;

use Core\DbContext,
    Core\Auth,
    Core\Response,
    Carbon\Carbon;

class Mailing {
    private $db = null;
    private $rm = null;
    private $table = 'am_mailing';

    public function __CONSTRUCT() {
        $this->db = DbContext::get();
        $this->rm = new Response();
    }

    public function add($data) {
        $record = $this->db->from($this->table)
                           ->where('email', $data['email'])
                           ->fetch();

        if(is_object($record)){
            $this->rm->result = 'exists';
            return $this->rm->setResponse(false, 'Este correo ya ha sido registrado');
        } else {
            $date = date('Y-m-d h:i:s');
            $data['added_at'] = $date;
            $data['updated_at'] = $date;
            
            // Sanatize
            $data['name'] = ucwords($data['name']);
            $data['name'] = explode(' ', $data['name'])[0];
            $data['email'] = strtolower($data['email']);

            $this->db->insertInto($this->table)
                 ->values($data)
                 ->execute();

            return $this->rm->setResponse(true);
        }
    }
    
    public function edit($id, $data) {
        $record = $this->db->from($this->table)
                           ->where('email', $data['email'])
                           ->where('id != ?', $id)
                           ->fetch();
        
        if(is_object($record)){
            return $this->rm->setResponse(false, 'Este correo ya ha sido registrado');
        } else {
            $data['updated_at'] = date('Y-m-d h:i:s');

            // Sanatize
            $data['name'] = ucwords($data['name']);
            $data['name'] = explode(' ', $data['name'])[0];
            $data['email'] = strtolower($data['email']);

            $this->db->update(
                $this->table, $data, $id
            )->execute();

            return $this->rm->setResponse(true);
        }
    }

    public function unsubscribe($ids) {
      foreach($ids as $id) {
        $this->db->update($this->table, ['inactive' => 1], $id)
                 ->execute();
      }

      return $this->rm->setResponse(true);
    }
    
    public function get($id){
      return $this->db->from($this->table)
                      ->where('id', $id)
                      ->fetch();
    }

    public function getAll(){
        /* AnexGrid */
        $anexgrid = new \App\Libs\AnexGrid();
        
        /* Query */
        $query = $this->db
           ->from($this->table)
           ->orderBy("$anexgrid->columna $anexgrid->columna_orden")
           ->limit($anexgrid->limite)
           ->offset($anexgrid->pagina);

        /* Filter */
        $ignoreDelete = false;
        foreach($anexgrid->filtros as $f)
        {
          if($f['columna'] === 'name') {
            $query = $query->where('name LIKE ?', $f['valor']);
          }

          if($f['columna'] === 'relation') {
            if($f['valor'] === 'no-group') {
              $query = $query->where('relation', '');
            } else {
              $query = $query->where('relation', $f['valor']);
            }
          }

          if($f['columna'] === 'email' && !empty($f['valor'])) {
            if(strtolower($f['valor']) === 'falsos') {
              $query = $query->where($this->fakeQuery());
            } else if(strtolower($f['valor']) === 'eliminados') {
              $query = $query->where('inactive', 1);
              $ignoreDelete = true;
            } else {
              $query = $query->where('email LIKE ?', '%' . $f['valor'] . '%');
            }
          }
        }

        if(!$ignoreDelete) {
            $query = $query->where('inactive', 0);
        }

        /* Records */
        $result = $query->fetchAll();

        /* Total of records */
        $query->limit(null);
        $query->offset(null);
        $total = $query->count();

        return $anexgrid->responde($result, $total);
    }

    public function groups(){
      return $this->db->from($this->table)
                  ->where('relation != ?', '')
                  ->groupBy('relation')
                  ->orderBy('relation')
                  ->select(null)->select('relation')
                  ->fetchAll();
    }

    public function export($inactive = 0, $relation = 'all'){
      $query = $this->db->from($this->table)
                  ->orderBy('added_at')
                  ->select(null)
                  ->select('name, email');

      $query = $query->where('inactive', $inactive);

      if($relation !== 'all'){
        $query = $query->where('relation', $relation);
      }

      $result = $query->fetchAll();
      
        return count($result) === 0 ? [
            ['name' => '', 'email' => '']
        ] : $result;
    }
    
    public function landing(){
        /* Today */
        $today = $this->db->from($this->table)
                          ->select(null)
                          ->select('count(*) total')
                          ->where('inactive', 0)
                          ->where('DATE(added_at) = CURDATE()')
                          ->fetch();
        
        /* Fake */
        $fake = $this->db->from($this->table)
                         ->select(null)
                         ->select('count(*) total')
                         ->where('inactive', 0);
        
        foreach(\Config::get()->trustedDomain as $domain) {
            $fake = $fake->where($this->fakeQuery());
        }
        
        $fake = $fake->fetch();
        
        /* Unsubscribe */
        $unsubscribe = $this->db->from($this->table)
                            ->select(null)
                            ->select('count(*) total')
                            ->where('inactive', 1)
                            ->fetch();
        
        $data = (object) [
            'today'       => is_object($today) ? $today->total : 0,
            'fake'        => is_object($fake) ? $fake->total : 0,
            'unsubscribe' => is_object($unsubscribe) ? $unsubscribe->total : 0,
        ];
        
        return $data;
    }
    
    public function chart(){
        $result = [];
    
        $query = $this->db->from($this->table)
                      ->select(null)
                      ->select('YEAR(added_at) year, MONTH(added_at) month, COUNT(*) total')
                      ->where('inactive', 0)
                      ->groupBy('YEAR(added_at), MONTH(added_at)')
                      ->orderBy('year, month');

		foreach($query->fetchAll() as $r){
            $r->{'mesView'} = \App\Helpers\monthToSpanish($r->month);
            
            $result[$r->year][] = $r;
        }
        
        return $result;
    }
    
    private function fakeQuery(){
      $trustedDomain = \Config::get()->trustedDomain;
      $fakeWhere = "(LENGTH(SUBSTRING(email, 1, INSTR(email, '@') - 1)) <= 4 OR ";

      foreach($trustedDomain as $k => $domain) {
        if($k === 0) {
            $fakeWhere .= '(';
        }

        $fakeWhere .= "email NOT LIKE '%$domain%'";

        if($k < count($trustedDomain) - 1) {
            $fakeWhere .= ' AND ';
        }

        if($k === count($trustedDomain) - 1) {
            $fakeWhere .= ')';
        }
      }

      $fakeWhere .= ')';
        
      return $fakeWhere;
    }
}