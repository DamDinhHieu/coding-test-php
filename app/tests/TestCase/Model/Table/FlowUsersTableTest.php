<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FlowUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FlowUsersTable Test Case
 */
class FlowUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FlowUsersTable
     */
    protected $FlowUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FlowUsers',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FlowUsers') ? [] : ['className' => FlowUsersTable::class];
        $this->FlowUsers = $this->getTableLocator()->get('FlowUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FlowUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FlowUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\FlowUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
