<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     block_capquizqtracker
 * @author      André Storhaug <andr3.storhaug@gmail.com>
 * @copyright   2020 NTNU
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version = 2021072200;
$plugin->requires = 2016120500;
$plugin->cron = 0;
$plugin->component = 'block_capquizqtracker';
$plugin->dependencies = array(
    'mod_capquiz' => ANY_VERSION,   // The Foo activity must be present (any version).
    'local_qtracker' => ANY_VERSION, // The Bar enrolment plugin version 2014020300 or higher must be present.
);
$plugin->maturity = MATURITY_BETA;
$plugin->release = '0.1.0';
