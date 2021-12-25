<?php

namespace Wikidot\DB;




use Ozone\Framework\Database\BaseDBPeer;

/**
 * Base peer Class mapped to the database table user_block.
 */
class UserBlockPeerBase extends BaseDBPeer
{
    public static $peerInstance;

    protected function internalInit()
    {
        $this->tableName='user_block';
        $this->objectName=UserBlock::class;
        $this->primaryKeyName = 'block_id';
        $this->fieldNames = array( 'block_id' ,  'site_id' ,  'user_id' ,  'reason' ,  'date_blocked' );
        $this->fieldTypes = array( 'block_id' => 'serial',  'site_id' => 'int',  'user_id' => 'int',  'reason' => 'text',  'date_blocked' => 'timestamp');
        $this->defaultValues = array();
    }

    public static function instance()
    {
        if (self::$peerInstance == null) {
            $className = UserBlockPeer::class;
            self::$peerInstance = new $className();
        }
        return self::$peerInstance;
    }
}
