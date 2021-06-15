<?php
//Loader para ajudar a carregar as classes

function loadModel($modelName)
{
    require_once(MODEL_PATH . "/{$modelName}.php");
}
//params caso seja necessário passar parametros
function loadView($viewName, $params = array())
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }
    require_once(VIEW_PATH . "/{$viewName}.php");
}

function loadTemplateView($viewName, $params = array())
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    //buscar o user á sessão
    $user = $_SESSION['user'];
    //registos do utilizador

    $workinghours = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
    $workedInterval = $workinghours->getWorkedInterval()->format('%H:%I:%S');
    $exitTime = $workinghours->getExitTime()->format('H:i:s');
    $activeClock = $workinghours->getActiveClock();

    require_once(TEMPLATE_PATH . "/header.php");
    require_once(TEMPLATE_PATH . "/menu.php");
    require_once(VIEW_PATH . "/{$viewName}.php");
    require_once(TEMPLATE_PATH . "/footer.php");
}

function renderTitle($title, $subtitle, $icon = null)
{
    require_once(TEMPLATE_PATH . "/title.php");
}
