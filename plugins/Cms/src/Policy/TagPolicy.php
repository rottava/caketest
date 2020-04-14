<?php
declare(strict_types=1);

namespace Cms\Policy;

use Cms\Model\Entity\Tag;
use Authorization\IdentityInterface;

/**
 * User policy
 */
class TagPolicy {
	public function canIndex(IdentityInterface $user, Tag $Tag) {
		return $user->get('level');
    }

    public function canAdd(IdentityInterface $user, Tag $tag) {
		return $user->get('level');
    }

    public function canEdit(IdentityInterface $user, Tag $tag) {
		return $user->get('level');
    }

    public function canDelete(IdentityInterface $user, Tag $tag) {
		return $user->get('level');
    }

    public function canView(IdentityInterface $user, Tag $tag) {
		return $user->get('level');
    }
}
