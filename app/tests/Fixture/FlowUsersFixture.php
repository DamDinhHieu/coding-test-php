<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FlowUsersFixture
 */
class FlowUsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'follower_id' => 1,
                'following_id' => 1,
            ],
        ];
        parent::init();
    }
}
