<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FlowUser Entity
 *
 * @property int $id
 * @property int $follower_id
 * @property int $following_id
 *
 * @property \App\Model\Entity\User $user
 */
class FlowUser extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'follower_id' => true,
        'following_id' => true,
        'user' => true,
    ];
}
