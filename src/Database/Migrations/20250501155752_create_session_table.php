<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSessionTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {

        $sessions = $this->table('sessions', ['id' => false, 'primary_key' => 'id']);

        $sessions->addColumn('id', 'string', ['limit' => 128])
            ->addColumn('data', 'text')
            ->addColumn('expires', 'integer', ['limit' => 11])
            ->create();

    }
}
