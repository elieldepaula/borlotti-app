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

final class CreateUserTable extends AbstractMigration
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

        // [!] Phinx automatically creates an auto-incrementing primary key column called id for every table.

        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('password_salt', 'string', ['limit' => 40])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('full_name', 'string', ['limit' => 100])
            ->addColumn('profile', 'text', ['limit' => 30])
            ->addColumn('avatar', 'string', ['limit' => 255])
            ->addIndex(['username', 'email'], ['unique' => true])
            ->addTimestamps()
            ->create();

    }
}
