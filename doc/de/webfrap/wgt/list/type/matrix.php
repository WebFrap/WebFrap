<h1>Matrix</h1>

<p>Matrix Elemente können zum dynamischen gruppieren von Datensätzen
in einer Matrix verwendet werden.</p>
<p>Eignet sich gut zum implementieren von Kanban like UI elementen</p>

<img src="images/webfrap/lists/matrix.png" />

<label>Einfache Erstellen einer Matrix</label>
<?php start_highlight(); ?>

$matrix = new WgtMatrixBuilder( $this );
$matrix->id = "wgt-matrix-project-tasks";
$matrix->searchURL = "ajax.php?c=fubar";
$matrix->addURL = "ajax.php?c=fubar";

$matrix->variantList = array(
  'counter' => 'Counter',
  'short' => 'Short',
  'tile' => 'Tile',
);

$matrix->groupList = array(
  'project_milestone_name' => 'Milestone',
  'project_task_category_name' => 'Category'
);

$matrix->fAxisX = 'project_milestone_name';
$matrix->fAxisY = 'project_task_category_name';


$matrix->cellRenderer = new WgtMatrix_Cell_Value( $this );
$matrix->cellRenderer->keyField = 'project_task-project_rowid';
$matrix->cellRenderer->labelField = 'project_task-project_title';


$matrix->data = $ELEMENT->treetableProjectTask->data;

$panel = new WgtPanelListing_Splitbutton( $matrix );
$panel->title = 'Task Matrix';
$panel->listType = 'matrix';
$panel->searchKey = 'matrix-project-tasks';

echo $matrix->render( );

<?php display_highlight( 'php' ); ?>


<label>Generiertes HTML</label>
<?php start_highlight(); ?>

<div>

  <div class="wgt-panel title">
    <h2>Task Matrix</h2>
  </div>

  <form
    action="ajax.php?c=fubar&amp;element=wgt-matrix-project-tasks"
    method="get"
    id="wgt-form-wgt-matrix-project-tasks" ></form>

  <div id="wgt-matrix-project-tasks-box" >
    <div class="wgt-panel">
      <button
        onclick="$R.get('ajax.php?c=fubar');"
        class="wgt-button"><img
          class="icon xsmall"
          alt="Create"
          src="icons/default/xsmall/control/add.png"> Create</button>
      &nbsp;|&nbsp;&nbsp;
      <label>Rows:</label>
      <select
        class="fparam-wgt-form-wgt-matrix-project-tasks medium"
        name="grow" >
          <option selected="selected" value="project_milestone_name">Milestone</option>
          <option value="project_task_category_name">Category</option>
      </select>&nbsp;|&nbsp;
      <label>Cols:</label>
      <select
        class="fparam-wgt-form-wgt-matrix-project-tasks medium"
        name="gcol" >
        <option value="project_milestone_name">Milestone</option>
        <option
          selected="selected"
          value="project_task_category_name">Category</option>
      </select>&nbsp;|&nbsp;
      <label>Show as:</label>
      <select
        class="fparam-wgt-form-wgt-matrix-project-tasks medium"
        name="vari" >
        <option value="counter">Counter</option>
        <option selected="selected" value="short">Short</option>
        <option value="tile">Tile</option>
      </select>
      &nbsp;&nbsp;
      <button
          onclick="$R.form('wgt-form-wgt-matrix-project-tasks');"
          class="wgt-button" ><img
            class="icon xsmall"
            alt="Refresh"
            src="icons/default/xsmall/control/refresh.png"> Refresh</button>
    </div>

    <table id="wgt-matrix-project-tasks" class="wgt-matrix">
      <thead>
        <tr>
          <th></th>
          <th>---</th>
          <th>Docu</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="head">---</td>
          <td> </td>
          <td> </td>
        </tr>
        <tr>
          <td class="head">Mst.  2</td>
          <td><a href="152693" class="">qwdqwd</a>, <a href="152704" class="">qwqwdqwd</a></td>
          <td> </td>
        </tr>
        <tr>
          <td class="head">Mst. 1</td>
          <td><a href="152682" class="">qwdqwd</a></td>
          <td> </td>
        </tr>
        <tr>
          <td class="head">Mst. 3</td>
          <td> </td>
          <td><a href="152698" class="">dddddd</a></td>
        </tr>
      </tbody>
    </table>

  </div>

</div>

<?php display_highlight( 'php' ); ?>