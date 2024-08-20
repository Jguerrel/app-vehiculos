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
        return 'Macs Marine';
      case self::TEST_2:
        return 'Wallenius';
      default:
        return 'N/A';
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

  // array datos agrupados
  public static function getData(): array
  {
    return [
      [
        'name' => self::getName(self::TEST_1),
        'val' => self::TEST_1,
      ],
      [
        'name' => self::getName(self::TEST_2),
        'val' => self::TEST_2,
      ]
    ];
  }
}
