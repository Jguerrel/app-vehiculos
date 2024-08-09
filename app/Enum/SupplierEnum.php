<?php

namespace App\Enum;

class SupplierEnum
{
  const TEST_1  = 1;
  const TEST_2  = 2;

  public static function getName($val)
  {
    switch ($val) {
      case self::TEST_1:
        return 'Primer proveedor';
      case self::TEST_2:
        return 'Segundo proveedor';
      default:
        return 'No definido';
    }
  }

  // array clave valor
  public static function getArrayKeyValue(): array
  {
    return [
      'test_1' => self::TEST_1,
      'test_2' => self::TEST_2,
    ];
  }
}
