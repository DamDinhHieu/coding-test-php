<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFlowUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('flow_users');
        $table->addColumn('follower_id', 'integer')
            ->addColumn('following_id', 'integer')
            ->addForeignKey('follower_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('following_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
