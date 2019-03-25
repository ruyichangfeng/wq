<?PHP
/** 
 * @Copyright (c)
 * @date          2013-05-4
 */

class SqlBuilder {

    /**
     * 检查字段的类型，确定要不要用边界符
     * @param String $fieldName
     * @return string
     */
    private static function _getFieldTypeMod($fieldName, $fieldTypes) {
        return isset($fieldTypes[$fieldName]) && $fieldTypes[$fieldName] == 'INT' ? '' : "'";
    }

    /**
     * 生成select sql 语句
     * @param string $tableName 表名
     * @param array $fieldTypes 字段注册
     * @param string $field 查询的字段
     * @param array|string $where 条件
     * @param string $orderBy 排序
     * @param int $limit 限制数量
     * @param int $offset 偏移
     * @return string sql语句
     */
    public static function createSelectSql($tableName, $fieldTypes, $field = '*', $where = '', $orderBy = '', $limit = 0, $offset = 0) {
        //order by
        $orderByPart = empty($orderBy) ? '' : " ORDER BY {$orderBy}";
        
        //limit
        $limit = intval($limit);
        $limitPart = $limit > 0 ? ' LIMIT ' . intval($offset) . ",{$limit}" : '';
        
        //where
        $wherePart = self::createWhereSql($where, $fieldTypes);
        return "SELECT {$field} FROM {$tableName}{$wherePart}{$orderByPart}{$limitPart}";
    }

    /**
     * 生成插入sql
     * @param array $data 插入的数据
     * @param array $fieldTypes 字段注册
     * @param string $tableName 表明
     * @return string sql语句
     */
    public static function createInsertSql($data, $fieldTypes, $tableName) {
        if (empty($tableName) || empty($data) || empty($fieldTypes)) {
            return '';
        }
        
        //过滤字段
        self::filterFields($data, $fieldTypes);
        
        $sqlFields = array();
        $sqlVaules = array();
        foreach ($data as $fieldName => $value) {
            $sqlFields[] = "`{$fieldName}`";
            $mod = self::_getFieldTypeMod($fieldName, $fieldTypes);
            $sqlVaules[] = $mod . self::mysqlEscapeMimic($value) . $mod;
        }
        
        $insertFields = implode(', ', $sqlFields);
        $insertValues = implode(', ', $sqlVaules);
        return "INSERT INTO `{$tableName}` ({$insertFields}) VALUES ({$insertValues})";
    }

    /**
     * 创建更新sql语句
     * @param type $setData 更新的数据
     * @param type $where 条件
     * @param type $fieldTypes 字段注册
     * @param type $tableName 表名
     * @return boolean
     */
    public static function createUpdateSql($setData, $where, $fieldTypes, $tableName) {
        if (empty($setData) || empty($where) || empty($tableName) || empty($fieldTypes)) {
            return false;
        }
        
        $setPart = self::createSetSql($setData, $fieldTypes);
        if (empty($setPart)) {
            return false;
        }
        
        $wherePart = self::createWhereSql($where);
        if (empty($wherePart)) {
            return false;
        }
        
        return "UPDATE {$tableName} {$setPart} {$wherePart}";
    }

    /**
     * 删除数据
     * @param $where WHERE
     * @return String sql
     */
    public static function createDeleteSql($where, $tableName, $fieldTypes) {
        if (empty($where) || empty($tableName) || empty($fieldTypes)) {
            return false;
        }
        
        $wherePart = self::createWhereSql($where);
        if (empty($wherePart)) {
            return false;
        }
        
        return "DELETE FROM {$tableName} {$wherePart}";
    }

    /**
     * 
     * 生成Where条件
     * @param String
     */
    public static function createWhereSql($where, $fieldTypes = array()) {
        if (empty($where)) {
            return '';
        }
        
        if (is_string($where)) {
            return " WHERE {$where}";
        }
        
        //根据字段过滤
        self::filterFields($where, $fieldTypes);
        
        //拼凑
        $keyValueParts = array();
        foreach ($where as $fieldName => $value) {
            $mod = self::_getFieldTypeMod($fieldName, $fieldTypes);
            $keyValueParts[] = self::_checkField($fieldName) . "=" . $mod . self::mysqlEscapeMimic($value) . $mod;
        }
        
        $keyValueStr = implode(' AND ', $keyValueParts);
        return " WHERE {$keyValueStr}";
    }

    /**
     * 
     * 生成Set语句
     * @param String or Array $data
     */
    protected static function createSetSql($setData, $fieldTypes) {
        if (empty($setData)) {
            return '';
        }
        
        if (is_string($setData)) {
            return " SET {$setData}";
        }
        
        //根据字段过滤
        self::filterFields($setData, $fieldTypes);
        
        //拼凑
        $keyValueParts = array();
        foreach ($setData as $fieldName => $value) {
            $mod = self::_getFieldTypeMod($fieldName, $fieldTypes);
            $keyValueParts[] = self::_checkField($fieldName) . "=" . $mod . self::mysqlEscapeMimic($value) . $mod;

        }
        
        $keyValueStr = implode(',', $keyValueParts);
        return " SET {$keyValueStr}";
    }

    /**
     * 
     * 过滤没用的字段，以及根据类型判断是否合格
     * @param Array $fields
     */
    protected static function filterFields(&$data, $fieldTypes) {
        if (empty($fieldTypes)) {
            return false;
        }
        
        $validData = array();
        foreach ($data as $key => $value) {
            //未注册的字段丢弃掉
            if (!isset($fieldTypes[$key])) {
                continue;
            }
            
            //根据类型验证
            if ($fieldTypes[$key] == 'INT') {
                if (!is_numeric($value)) {
                    continue;
                }
                $value = intval($value);
            } elseif ($fieldTypes[$key] == 'VARCHAR') {
                if (!is_string($value)) {
                    continue;
                }
            } else {
                continue;
            }
            
            $validData[$key] = $value;
        }
        
        $data = $validData;
    }
    
	/**
	 * @breif 模拟 mysql escape， 推荐使用 mysqli_real_escape_string
	 * @param mix $inp
	 * @return string
	 */
	public static function mysqlEscapeMimic($inp) {
        if(is_array($inp)) {
            return array_map(__METHOD__, $inp);
        }
        if(!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }
        return $inp;
    }

    /**
     * 
     * 检查字段名
     * 过滤掉特殊字符（不包含.） 得到合法的字符
     * @param String $field
     */
    private static function _checkField($fieldName) {
        $fieldName = preg_replace('/[^\w\.]/', '', $fieldName);
        
        $pos = strpos($fieldName, '.');
        if($pos > 0){
            $fieldName = str_replace('.', "`.`", $fieldName);
        } elseif($pos === 0){
            $fieldName = substr($fieldName, 1);
        }

        return "`{$fieldName}`";
    }
    
}
