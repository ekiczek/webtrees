<?php
/**
 * webtrees: online genealogy
 * Copyright (C) 2018 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Fisharebest\Webtrees\Statistics\Google;

use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Statistics\AbstractGoogle;
use Fisharebest\Webtrees\Theme;

/**
 *
 */
class ChartIndividual extends AbstractGoogle
{
    /**
     * Create a chart showing individuals with/without sources.
     *
     * @param int         $tot_indi        The total number of individuals
     * @param int         $tot_indi_source The total number of individuals with sources
     * @param string|null $size
     * @param string|null $color_from
     * @param string|null $color_to
     *
     * @return string
     */
    public function chartIndisWithSources(
        int $tot_indi, int $tot_indi_source, string $size = null, string $color_from = null, string $color_to = null
    ): string {
        $chart_color1 = (string) Theme::theme()->parameter('distribution-chart-no-values');
        $chart_color2 = (string) Theme::theme()->parameter('distribution-chart-high-values');
        $chart_x      = Theme::theme()->parameter('stats-small-chart-x');
        $chart_y      = Theme::theme()->parameter('stats-small-chart-y');

        $size       = $size ?? ($chart_x . 'x' . $chart_y);
        $color_from = $color_from ?? $chart_color1;
        $color_to   = $color_to ?? $chart_color2;

        $sizes    = explode('x', $size);

        if ($tot_indi === 0) {
            return '';
        }

        $tot_sindi_per = $tot_indi_source / $tot_indi;
        $with          = (int) (100 * $tot_sindi_per);
        $chd           = $this->arrayToExtendedEncoding([100 - $with, $with]);
        $chl           = I18N::translate('Without sources') . ' - ' . I18N::percentage(1 - $tot_sindi_per, 1) . '|' . I18N::translate('With sources') . ' - ' . I18N::percentage($tot_sindi_per, 1);
        $colors        = [$color_from, $color_to];

        return view(
            'statistics/other/chart-google',
            [
                'chart_title' => I18N::translate('Individuals with sources'),
                'chart_url'   => $this->getPieChartUrl($chd, $size, $colors, $chl),
                'sizes'       => $sizes,
            ]
        );
    }
}