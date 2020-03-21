<?php

namespace App\ProductCatalog\Application\Voter;

use App\ProductCatalog\Domain\Model\Product;
use App\User\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProductVoter extends Voter
{
    public const DELETE = 'delete';

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Product) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        //admin can delete everything
        if ($this->security->isGranted(User::ROLE_ADMIN)) {
            return true;
        }

        /** @var $user User */
        $user = $token->getUser();

        /** @var $product Product */
        $product = $subject;

        switch ($attribute) {
            case self::DELETE:
                 return $product->canDelete($user->id());
        }

        throw new \Exception('This code should not be reached!');
    }
}
