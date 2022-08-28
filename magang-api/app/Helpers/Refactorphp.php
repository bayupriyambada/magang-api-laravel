<?php

namespace App\Helpers;


class Refactorphp
{

  public function isSpecialDiscount($isSpecialDiscount, $price)
  {
    #consolidate-duplicate-conditional-fragments_after.php

    // refactoring 1
    $tax = $isSpecialDiscount ? 95 : 98;
    return $price * $tax;

    // refactoring 2
    return $isSpecialDiscount ? $price * 95 : $price * 98;
  }


  public function isDisibilyAmount(
    $isNotEligibleForDisability,
    $seniority,
    $monthsDisabled,
    $isPartTime
  ) {
    #consolidate-conditional-expression_after.php

    return $isNotEligibleForDisability ?: 0;

    #consolidate-conditional-expression_before.php

    // if ($this->seniority < 2) {
    //   return 0;

    // refactoring $seniority with ternary
    return $seniority < 2 ?: 0;

    // refactoring $monthsDisabled with ternary
    return $monthsDisabled > 12 ?: 0;

    // refactoring $isPartTime with ternary
    return $isPartTime ?: 0;
  }
}
