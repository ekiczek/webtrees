<?php

namespace Fisharebest\Localization\Locale;

use Fisharebest\Localization\Territory\TerritoryTz;

/**
 * Class LocaleMasTz
 *
 * @author    Greg Roach <fisharebest@gmail.com>
 * @copyright (c) 2019 Greg Roach
 * @license   GPLv3+
 */
class LocaleMasTz extends LocaleMas
{
    public function territory()
    {
        return new TerritoryTz();
    }
}
