<?php

namespace App\Helper\Object;

use App\Helper\BaseObject;
use App\Models\User;

class UserProfileObject
{
    use BaseObject;

    private string $uuid;
    private int $id;
    private string $name;

    private string $avatar;

    private string $branch;
    private string $email;
    private string $phone;
    private string $role;


    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getRoleLabel(): string
    {
        switch ($this->role) {
            case User::STUDENT_ROLE:
                return 'Hoc sinh';
            case User::HOST_ROLE:
                return 'HOST';
            case User::STAFF_ROLE:
                return 'Nhan vien';
            case User::TEACHER_ROLE:
                return 'Giao vien';
            case User::SUPPORTER_ROLE:
                return 'Tro giang';
            default:
                return '';
        }
    }
}
