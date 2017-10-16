<?php
/*
 * This file is part of PHPinnacle/Domain.
 *
 * (c) PHPinnacle Team <dev@phpinnacle.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPinnacle\Domain;

interface Entity
{
    /**
     * Returns entity unique identifier
     *
     * @return ID
     */
    public function getID(): ID;
}
