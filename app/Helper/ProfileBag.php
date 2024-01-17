<?php

namespace App\Helper;

use App\Helper\Object\CustomFieldShow;
use App\Helper\Object\UserProfileObject;

class ProfileBag
{
    private UserProfileObject $userProfileObject;
    private string $entity;

    private array $customFields = [];

    /**
     * @return CustomFieldShow[]
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @param CustomFieldShow $customField
     * @return void
     */
    public function addCustomField(CustomFieldShow $customField): void
    {
        $this->customFields[] = $customField;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    public function setUserProfileObject(UserProfileObject $userProfileObject): void
    {
        $this->userProfileObject = $userProfileObject;
    }

    public function getUserProfileObject(): UserProfileObject
    {
        return $this->userProfileObject;
    }
}
