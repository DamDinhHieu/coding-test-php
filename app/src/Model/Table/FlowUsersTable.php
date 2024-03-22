<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FlowUsers Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 *
 * @method \App\Model\Entity\FlowUser newEmptyEntity()
 * @method \App\Model\Entity\FlowUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FlowUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FlowUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\FlowUser findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FlowUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FlowUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FlowUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FlowUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FlowUser[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FlowUser[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FlowUser[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FlowUser[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FlowUsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('flow_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'follower_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'following_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('follower_id')
            ->notEmptyString('follower_id');

        $validator
            ->integer('following_id')
            ->notEmptyString('following_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('follower_id', 'Users'), ['errorField' => 'follower_id']);
        $rules->add($rules->existsIn('following_id', 'Users'), ['errorField' => 'following_id']);

        return $rules;
    }
}
