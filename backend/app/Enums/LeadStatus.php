<?php

namespace App\Enums;

enum LeadStatus: string
{
  case NEW = 'new';
  case QUALIFIED = 'qualified';
  case DISQUALIFIED = 'disqualified';
  case CONVERTED = 'converted';
}
