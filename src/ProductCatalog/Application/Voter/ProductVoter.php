<?php

namespace App\ProductCatalog\Application\Voter;

use App\ProductCatalog\Domain\Model\Product;
use App\User\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductVoter extends Voter
{
    public const DELETE = 'delete';

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
