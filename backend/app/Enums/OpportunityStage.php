<?php

namespace App\Enums;

enum OpportunityStage: string
{
  case INITIAL_CONTACT = 'initial_contact';
  case DISCUSSION = 'discussion';
  case PROPOSAL = 'proposal';
  case NEGOTIATION = 'negotiation';
  case CONTRACT_PROCESSING = 'contract_processing';
  case WON = 'won';
  case LOST = 'lost';
}
