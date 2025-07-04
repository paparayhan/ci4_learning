<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','unisgned'=>TRUE,'auto_incement'=>TRUE],
            'title'=>['type'=>'VARCHAR','constraint'=>128, 'null'=>FALSE],
            'content'=>['type'=>'TEXT','null'=>FALSE],
            'slug'=>['type'=>'VARCHAR','constraint'=>128,'null'=>FALSE],
            'status'=>['type'=>'INT','constraint'=>1,'null'=>FALSE],
            'created_at'=>['type'=>'datetime','null'=>FALSE],
            'updated_at'=>['type'=>'datetime','null'=>FALSE],
            'deleted_at'=>['type'=>'datetime','null'=>FALSE]
        ]);
        $this->forge->addKey('id',TRUE);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
