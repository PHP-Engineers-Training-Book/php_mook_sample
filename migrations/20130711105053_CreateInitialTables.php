<?php

use Phpmig\Migration\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `posts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `message` text NOT NULL,
                `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `created` (`created`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            INSERT INTO posts(name, message) values('omoon', 'Hello sample!');

        ";
        $container = $this->getContainer(); 
        $container['db']->query($sql);

    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `posts`";
        $container = $this->getContainer(); 
        $container['db']->query($sql);

    }
}
