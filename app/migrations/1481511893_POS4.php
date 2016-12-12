<?php

class Pos4 extends Redix\Migration\Migration
{
    public function up()
    {
        $this->redis->set('test', 'test-value');
        $this->redis->save();
    }

    public function down()
    {
        $this->redis->del([
            'test'
        ]);
    }
}
