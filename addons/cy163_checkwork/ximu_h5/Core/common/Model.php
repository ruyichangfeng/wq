<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator          |
    |              on 2018-05-26 11:06:34              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Core\common; class Model { private static $self; private $table; private $where = array(); private $field = array(); private $limit = array(); private $order = ''; private $keyField = ''; protected function table($table) { $this->table = $table; return $this; } public function where($where = array()) { goto vUGKQ; AZes9: gDqxh: goto INjsp; vUGKQ: if (!$where) { goto gDqxh; } goto o3ch8; INjsp: return $this; goto cVk_0; o3ch8: $this->where = array_merge($this->where, $where); goto AZes9; cVk_0: } public function order($order) { $this->order = $order; return $this; } public function field($field) { goto yc2kB; Trzqx: $field = explode("\x2c", trim($field, "\54")); goto Xt1wQ; Xt1wQ: L2q1h: goto xQIzs; xQIzs: $this->field = $field; goto T7Jns; yc2kB: if (!is_string($field)) { goto L2q1h; } goto Trzqx; T7Jns: return $this; goto pUrkm; pUrkm: } public function keyField($key) { goto d0kpj; Af4bb: return $this; goto LzPCA; Gf2WN: gxK2l: goto Af4bb; K4MHy: $this->keyField = $key; goto Gf2WN; d0kpj: if (!$key) { goto gxK2l; } goto K4MHy; LzPCA: } public function limit($limit, $end = '') { goto Px1hq; Px1hq: if (!$end) { goto x7NfK; } goto ChAOi; w6qP9: return $this; goto B_HNy; EdqgW: $this->limit = $limit; goto w6qP9; ChAOi: $this->limit = array($limit, $end); goto WIEug; eGc2f: x7NfK: goto EdqgW; WIEug: return $this; goto eGc2f; B_HNy: } public function find($field = '') { goto qusGb; R_rSP: return $data; goto w4nmR; dVZZI: $this->__endDestruct(); goto R_rSP; itk_d: if (!is_string($field)) { goto cts3H; } goto UYdUi; qusGb: if (!$field) { goto J2RMy; } goto XiRQz; yTeoQ: J2RMy: goto f0rIT; UYdUi: $this->field = explode("\x2c", $field); goto pTqnY; XiRQz: $this->field = $field; goto itk_d; pTqnY: cts3H: goto yTeoQ; f0rIT: $data = pdo_get($this->table, $this->where, $this->field); goto dVZZI; w4nmR: } public function select() { goto nhVri; CPF3i: $this->__endDestruct(); goto L1fLq; nhVri: $data = pdo_getall($this->table, $this->where, $this->field, $this->keyField, $this->order, $this->limit); goto CPF3i; L1fLq: return $data; goto IRISz; IRISz: } public function update($data, $where = array()) { goto ztYNT; uG2me: $this->__endDestruct(); goto o24B2; gpexw: $this->where = array_merge($this->where, $where); goto ide91; T8aQN: $result = pdo_update($this->table, $data, $this->where); goto uG2me; ide91: G1tUJ: goto T8aQN; ztYNT: if (!$where) { goto G1tUJ; } goto gpexw; o24B2: return $result; goto QEfoc; QEfoc: } public function delete($where = array()) { goto XSHfo; Xj0vs: $result = pdo_delete($this->table, $this->where); goto o86Qx; ZW3N1: $this->where = array_merge($this->where, $where); goto rsaWe; R1IZm: return $result; goto jW6m1; XSHfo: if (!$where) { goto w3Jsn; } goto ZW3N1; o86Qx: $this->__endDestruct(); goto R1IZm; rsaWe: w3Jsn: goto Xj0vs; jW6m1: } public function insert($data, $table = '') { goto LZ53U; tP1TV: $result = pdo_insert($this->table, $data); goto IsJUB; VPCgQ: return $result; goto FAyfc; LaLzz: C1ljh: goto tP1TV; t5E8r: $this->table = $table; goto LaLzz; IsJUB: $this->__endDestruct(); goto VPCgQ; LZ53U: if (!$table) { goto C1ljh; } goto t5E8r; FAyfc: } public function save($data, $where = array()) { goto AnWfw; eW233: qWRWR: goto Bufmj; lOPIm: H9bxZ: goto RlrrE; R1xW4: $where = array("\151\144" => $data["\x69\x64"]); goto eW233; Bufmj: if (!$where) { goto H9bxZ; } goto SsTSl; RlrrE: return $this->insert($data); goto YU2Zu; SsTSl: return $this->update($data, $where); goto lOPIm; AnWfw: if (!(empty($where) && $data["\151\x64"])) { goto qWRWR; } goto R1xW4; YU2Zu: } public function count($where = array()) { goto Mw6ob; C2ihv: $this->where = array_merge($this->where, $where); goto py0eh; py0eh: Sm_PJ: goto Dj7RC; Dj7RC: $this->__endDestruct(); goto IsPXc; IsPXc: return pdo_count($this->table, $this->where); goto R3DF0; Mw6ob: if (!$where) { goto Sm_PJ; } goto C2ihv; R3DF0: } public function query($sql, $params = array()) { return pdo_query($sql, $params); } public function __call($name, $arguments) { goto FZZU1; FZZU1: $instance = static::getInstance(); goto hUHTa; hUHTa: if (!method_exists($instance, $name)) { goto PFMv3; } goto pYkvn; jlj0u: throw new \Exception("\346\226\xb9\346\xb3\225\72" . $name . "\xe4\xb8\215\345\xad\230\345\234\250"); goto u0m_4; pYkvn: return call_user_func_array(array($instance, $name), $arguments); goto sgBr_; sgBr_: PFMv3: goto jlj0u; u0m_4: } public static function __callStatic($name, $arguments) { goto G9S4g; L3XeB: PLAUi: goto GQYfB; GQYfB: throw new \Exception("\xe6\x96\271\xe6\xb3\225\72" . $name . "\344\xb8\215\xe5\xad\230\345\234\xa8"); goto Ymo7c; bES8K: return call_user_func_array(array($instance, $name), $arguments); goto L3XeB; v8rVR: if (!method_exists($instance, $name)) { goto PLAUi; } goto bES8K; G9S4g: $instance = static::getInstance(); goto v8rVR; Ymo7c: } private static function getInstance() { goto b3kAS; sDDoN: return self::$self; goto xrN_C; z82lh: self::$self = new Model(); goto su6p0; b3kAS: if (!(self::$self === null)) { goto F3VdY; } goto z82lh; su6p0: F3VdY: goto sDDoN; xrN_C: } private function __endDestruct() { goto oyBmQ; zzqh0: $this->order = ''; goto YnGSS; oyBmQ: $this->limit = array(); goto oi7BE; bxRb2: $this->field = array(); goto zzqh0; YnGSS: $this->keyField = ''; goto IFRwn; oi7BE: $this->where = array(); goto bxRb2; IFRwn: } }