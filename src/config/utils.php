<?php

namespace config;

class utils
{

  public static function UUID(): string
  {
    $data = random_bytes(16);
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }

  public static function code(string $prefix): string
  {
    $hex = strtoupper(bin2hex(random_bytes(3)));
    return strtoupper($prefix) . '-' . $hex;
  }

  public static function formatDate(?string $date): string
  {
    if (!$date) {
      return '—';
    }
    return date('d/m', strtotime($date));
  }
}
