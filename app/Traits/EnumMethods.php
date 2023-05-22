<?php

namespace App\Traits;

use Error;
use ReflectionEnum;

trait EnumMethods
{
    public static function all(): \Illuminate\Support\Collection
    {
        $enums = collect();
        foreach (self::cases() as $enum) {
            $enums->put($enum->value, $enum->name());
        }

        return $enums;
    }

    public static function only(array $types): \Illuminate\Support\Collection
    {
        $enums = collect();
        foreach (self::cases() as $enum) {
            if (in_array($enum->value, $types)) {
                $enums->put($enum->value, $enum->name());
            }
        }

        return $enums;
    }

    public static function getEnumByLabel(string $label): self | null
    {
        $all = self::all();
        return self::tryFrom($all->search($label));
    }

    public function __call(string $name, mixed $arguments): bool
    {
        strtolower(substr($name, 0, 2)) === 'is' or throw new Error("method doesnt exist", 1);
        $enum = strtoupper(substr($name, 2));
        $class = $this::class;

        $reflection = new ReflectionEnum($class);
        $enum = $reflection->hasConstant($enum) ? $reflection->getConstant($enum) : throw new Error("'$enum' is not a valid backing value for enum '$class'", 1);

        return $this->value === $enum->value ?? false;
    }
}
