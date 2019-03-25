<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-27 10:26:55              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Core\common; class Model { private static $self; private $table; private $where = array(); private $field = array(); private $limit = array(); private $order = ''; private $keyField = ''; protected function table($table) { $this->table = $table; return $this; } public function where($where = array()) { goto guGq8; K4EpH: Zq2B9: goto ACNQM; guGq8: if (!$where) { goto Zq2B9; } goto CoyvE; CoyvE: $this->where = array_merge($this->where, $where); goto K4EpH; ACNQM: return $this; goto kXM87; kXM87: } public function order($order) { $this->order = $order; return $this; } public function field($field) { goto atqbM; E1wvW: $field = explode("\x2c", trim($field, "\x2c")); goto tcHZG; tcHZG: DRShB: goto GRNuz; te_fN: return $this; goto lQW76; GRNuz: $this->field = $field; goto te_fN; atqbM: if (!is_string($field)) { goto DRShB; } goto E1wvW; lQW76: } public function keyField($key) { goto mi9un; PajUi: $this->keyField = $key; goto I8CYH; mi9un: if (!$key) { goto UBfHJ; } goto PajUi; UuMFw: return $this; goto leoJ9; I8CYH: UBfHJ: goto UuMFw; leoJ9: } public function limit($limit, $end = '') { goto OCDsG; umFFn: return $this; goto eVuTL; fgrfg: return $this; goto DcjIc; OCDsG: if (!$end) { goto k2Mta; } goto Ekof1; DcjIc: k2Mta: goto wx1l7; wx1l7: $this->limit = $limit; goto umFFn; Ekof1: $this->limit = array($limit, $end); goto fgrfg; eVuTL: } public function find($field = '') { goto JEV2Y; Hwati: return $data; goto nTwbf; Y6nX2: $this->__endDestruct(); goto Hwati; ec1es: gjoDv: goto xwF7k; r84q8: $this->field = explode("\x2c", $field); goto ec1es; JEV2Y: if (!$field) { goto RT_am; } goto eAnUq; xwF7k: RT_am: goto vJOlD; unG6u: if (!is_string($field)) { goto gjoDv; } goto r84q8; eAnUq: $this->field = $field; goto unG6u; vJOlD: $data = pdo_get($this->table, $this->where, $this->field); goto Y6nX2; nTwbf: } public function select() { goto VWVhy; yAfU8: $this->__endDestruct(); goto kp_h2; kp_h2: return $data; goto eo4qT; VWVhy: $data = pdo_getall($this->table, $this->where, $this->field, $this->keyField, $this->order, $this->limit); goto yAfU8; eo4qT: } public function update($data, $where = array()) { goto jMFR7; ILLV_: $this->where = array_merge($this->where, $where); goto cUti1; x1V2_: $result = pdo_update($this->table, $data, $this->where); goto uF5L3; uF5L3: $this->__endDestruct(); goto fWuM5; cUti1: j4LGh: goto x1V2_; jMFR7: if (!$where) { goto j4LGh; } goto ILLV_; fWuM5: return $result; goto Uje2u; Uje2u: } public function delete($where = array()) { goto s85Zb; dYXnA: return $result; goto JKEI5; s85Zb: if (!$where) { goto glDSQ; } goto X7wcO; nWwqk: $result = pdo_delete($this->table, $this->where); goto YsQX3; YsQX3: $this->__endDestruct(); goto dYXnA; X7wcO: $this->where = array_merge($this->where, $where); goto I6jlf; I6jlf: glDSQ: goto nWwqk; JKEI5: } public function insert($data, $table = '') { goto RDJ1N; RDJ1N: if (!$table) { goto QmyCc; } goto pp22J; pp22J: $this->table = $table; goto ojQYN; QME27: return $result; goto BwPsh; LyYbU: $result = pdo_insert($this->table, $data); goto NE2Uq; ojQYN: QmyCc: goto LyYbU; NE2Uq: $this->__endDestruct(); goto QME27; BwPsh: } public function save($data, $where = array()) { goto dqC2D; awxpm: YzfvY: goto axWi_; dujP6: G0Hh2: goto LFpvM; LFpvM: if (!$where) { goto YzfvY; } goto W7YL9; axWi_: return $this->insert($data); goto wV7B0; dqC2D: if (!(empty($where) && $data["\151\144"])) { goto G0Hh2; } goto nak5R; W7YL9: return $this->update($data, $where); goto awxpm; nak5R: $where = array("\151\144" => $data["\151\x64"]); goto dujP6; wV7B0: } public function query($sql, $params = array()) { return pdo_query($sql, $params); } public function __call($name, $arguments) { goto biGrh; biGrh: $instance = static::getInstance(); goto LKDuR; LKDuR: if (!method_exists($instance, $name)) { goto K6Qbm; } goto gDSnF; d75J2: K6Qbm: goto wfagT; wfagT: throw new \Exception("\346\x96\xb9\xe6\xb3\225\x3a" . $name . "\xe4\xb8\215\345\xad\230\345\234\250"); goto OtTqh; gDSnF: return call_user_func_array(array($instance, $name), $arguments); goto d75J2; OtTqh: } public static function __callStatic($name, $arguments) { goto ORopO; vNlpT: return call_user_func_array(array($instance, $name), $arguments); goto nCXPk; PQCDU: if (!method_exists($instance, $name)) { goto Ilt7c; } goto vNlpT; nCXPk: Ilt7c: goto IMPh9; IMPh9: throw new \Exception("\xe6\226\271\346\263\225\72" . $name . "\344\xb8\x8d\345\255\230\xe5\234\250"); goto VcB4l; ORopO: $instance = static::getInstance(); goto PQCDU; VcB4l: } private static function getInstance() { goto jorSl; ugH3m: aX6ay: goto Lb05W; Lb05W: return self::$self; goto FWJ2P; yWbRh: self::$self = new Model(); goto ugH3m; jorSl: if (!(self::$self === null)) { goto aX6ay; } goto yWbRh; FWJ2P: } private function __endDestruct() { goto IKn_x; zIWrX: $this->where = array(); goto ad1uN; hylMF: $this->order = ''; goto hF5vZ; ad1uN: $this->field = array(); goto hylMF; IKn_x: $this->limit = array(); goto zIWrX; hF5vZ: $this->keyField = ''; goto P0DzP; P0DzP: } }