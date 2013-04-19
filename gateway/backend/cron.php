#!/usr/bin/php
<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

try {

  if (php_sapi_name () != 'cli' || !empty ($_SERVER['REMOTE_ADDR']))
    die ('Invalid Call');

  include './conf/bootstrap.cron.php';

  View::setType ('Cli');

  $webfrap = Webfrap::init ();

  /**
   *
   * @var LibDbOrm
   */
  $orm = Webfrap::$env->getOrm ();
  $tasks = new TaskList ($orm);

  foreach ($tasks->loadTaskList () as $task) {
    try {
      createUserSessionBasedOn ($task['id_user']);

      // calling the main main funct:wqion
      $triple = sprintf ('%s,%s,%s', $task['mod'], $task['con'], $task['run']);
      $webfrap->main ($triple, $task['parameters'], $task['request_body']);

      if ($task['iterations'] === 1) {
        $task['task_disabled'] = TRUE;
        $task['last_state'] = 'OK_FINISHED';
      } else
        if (intval ($task['iterations']) > 1) {
          $task['iterations'] = intval ($task['iterations']) - 1;
        }

      $task['last_state'] = 'OK_RESCHEDULE';
      $task['latest_execution'] = new DateTime ();

      $orm->save ($task);
    } catch (Exception $exception) {
      logError ();

      $task['latest_execution'] = new DateTime ();

      switch ($task['on_error']) {
        case 'REPEAT':
          $task['last_state'] = 'ERROR_REPEAT';
          break;
        case 'RESCHEDULE':
          if ($task['iterations'] > 1) {
            $task['iterations'] = $task['iterations'] - 1;
            $task['last_state'] = 'ERROR_RESCHEDULE';
          } else
            if ($task['iterations'] === 1) {
              $task['last_state'] = 'ERROR_FINISHED';
              $task['task_disabled'] = TRUE;
            } else {
              $task['last_state'] = 'ERROR_RESCHEDULE';
            }
          break;
        case 'ABORT':
        default:
          $task['last_state'] = 'ERROR_ABORT';
          $task['task_disabled'] = TRUE;
      }

      $orm->save ($task);
    }
  }

  $webfrap->shutdown ();

} // ENDE TRY
catch (Exception $exception) {
  $extType = get_class ($exception);

  Error::addError ('Uncatched  Exception: ' . $extType . ' Message:  ' . $exception->getMessage (), null, $exception);

  LibTemplateCli::printErrorPage ($exception->getMessage (), $exception);

}

class TaskList
{
  /**
   *
   * @var LibDbOrm
   */
  private $orm;

  public function __construct (LibDbOrm $orm)
  {
    $this->orm = $orm;
  }

  public function loadTaskList ()
  {
    $tasks = $this->orm->getAll ('WbfsysCronTask');

    // TODO ms: filter tasks in database
    return array_filter ($tasks, array ($this, 'filter'));
  }

  private function filter ($task)
  {
    $now = new DateTime ();

    $startDate = new DateTime ($task['start_time']);
    $latestExecution = $startDate;

    if ($task['task_disabled']) {
      return FALSE;
    }

    if (!empty ($task['latest_execution'])) {
      $latestExecution = new DateTime ($task['latest_execution']);
    }

    if ($now < $startDate) {
      return FALSE;
    }

    if ($task['iterations'] === 1) {
      return TRUE;
    }

    $interval = new DateInterval ($task['interval']);
    $nextExecution = $latestExecution->add ($interval);

    return $now < $nextExecution;

  }
}