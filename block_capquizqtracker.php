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
 * Main interface to Question Tracker
 * 
 * Provides block for registering question issues for quiz module
 *
 * @package     block_capquizqtracker
 * @author      André Storhaug <andr3.storhaug@gmail.com>
 * @copyright   2020 NTNU
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use \local_qtracker\output\issue_registration_block;
use \mod_capquiz\capquiz;
use \mod_capquiz\capquiz_attempt;

defined('MOODLE_INTERNAL') || die();

class block_capquizqtracker extends block_base {
    public function init() {
        $this->title = get_string('capquizqtracker_quiz', 'block_capquizqtracker');
    }

    public function applicable_formats() {
        return array('all' => false, 'mod-capquiz' => true);
    }

    function has_config() {
        return true;
    }

    function get_content() {
        global $COURSE, $USER, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->text = '';
        $this->content->footer = '';

        // Get submitted parameters.
        $cmid = optional_param('id', null, PARAM_INT);
        $capquiz = new capquiz($cmid);

        if (has_capability('mod/capquiz:instructor', $capquiz->context())) {
            $url = new moodle_url('/local/qtracker/view.php', array('courseid' => $COURSE->id));
            $this->content->text = html_writer::link($url, "View issues...");
            return $this->content;
        }

        $currentcontext = $this->page->context->get_course_context(false);
        if (!empty($this->config->text)) {
            $this->content->text = $this->config->text;
        }

        if (empty($currentcontext)) {
            return $this->content;
        }

        if ($this->page->course->id == SITEID) {
            $this->content->text .= "site context";
        }

        if (isset($this->config->text)) {
            $this->content->text = $this->config->text;
        } else {
            $this->content->text = html_writer::tag('p', get_string('question_problem_details', 'block_capquizqtracker'));
        }

        $this->userid = $USER->id;

        $quba = $capquiz->question_usage();
        $qengine = $capquiz->question_engine();
        $attempt = $qengine->attempt_for_current_user();
        $slot = $attempt->question_slot();

        $renderer = $this->page->get_renderer('local_qtracker');
        $context = $PAGE->context;
        $templatable = new issue_registration_block($quba, [$slot], $context->id);
        $this->content->text .= $renderer->render($templatable);
        return $this->content;
    }
}
