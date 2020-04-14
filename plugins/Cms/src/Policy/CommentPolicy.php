<?php
declare(strict_types=1);

namespace Cms\Policy;

use Cms\Model\Entity\Comment;
use Authorization\IdentityInterface;

class CommentPolicy {
	public function canIndex(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }
    
    public function canAdd(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }

    public function canEdit(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }

    public function canDelete(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }

    public function canView(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }
	
	public function canFilter(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }
	
	public function canStatusChange(IdentityInterface $user, Comment $comment) {
		return $user->get('level');
    }
	
}
