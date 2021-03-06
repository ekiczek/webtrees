<?php

/**
 * webtrees: online genealogy
 * Copyright (C) 2021 webtrees development team
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Fisharebest\Webtrees;

use Fisharebest\Webtrees\Http\RequestHandlers\SubmissionPage;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * A GEDCOM submission (SUBN) object.
 * These records are only used when transferring data between two obsolete systems.
 * There is no need to create them - but we may encounter them in imported GEDCOM files.
 */
class Submission extends GedcomRecord
{
    public const RECORD_TYPE = 'SUBN';

    protected const ROUTE_NAME = SubmissionPage::class;

    /**
     * Fetch data from the database
     *
     * @param string $xref
     * @param int    $tree_id
     *
     * @return string|null
     */
    protected static function fetchGedcomRecord(string $xref, int $tree_id): ?string
    {
        return DB::table('other')
            ->where('o_id', '=', $xref)
            ->where('o_file', '=', $tree_id)
            ->where('o_type', '=', static::RECORD_TYPE)
            ->value('o_gedcom');
    }

    /**
     * Extract names from the GEDCOM record.
     *
     * @return void
     */
    public function extractNames(): void
    {
        $this->getAllNames[] = [
            'type'   => static::RECORD_TYPE,
            'sort'   => I18N::translate('Submission'),
            'full'   => I18N::translate('Submission'),
            'fullNN' => I18N::translate('Submission'),
        ];
    }
}
