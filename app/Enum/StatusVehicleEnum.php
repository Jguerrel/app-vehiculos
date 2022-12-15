<?php

/**
 * gestión de los estados de los vehículos
 *
 * @author luisandev
 */

namespace App\Enum;

final class StatusVehicleEnum
{
  public const AVAILABLE = 1;
  public const PENDING = 2;
  public const MAINTENANCE = 3;
  public const IN_REPAIR = 4;
  public const REPAIRED = 5;

  public static function getValues(): array
  {
    return [
      self::AVAILABLE,
      self::PENDING,
      self::MAINTENANCE,
      self::IN_REPAIR,
      self::REPAIRED,
    ];
  }

  public static function getLabels($status = null): array
  {
    $labels = [
      self::AVAILABLE => 'Disponible',
      self::PENDING => 'Pendiente',
      self::MAINTENANCE => 'En mantenimiento',
      self::IN_REPAIR => 'En Reparación',
      self::REPAIRED => 'Reparado',
    ];

    if ($status) {
      return $labels[$status];
    }

    return $labels;
  }
}
