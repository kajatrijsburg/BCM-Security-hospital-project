<?php
require_once("../php/sql.php");
require_once("../php/clean-input.php");
include_once("../partials/session_part.php");
require_once ("../php/permissies.php");
requirePermission($_SESSION, Permissions::$manageTreatmentPlan);

$id = validateID($_POST["user"]);

$description = validateText($_POST["description"]);

$db = new DataBase();

$date = date("Y-m-d");
$db->addTreatmentPlan($id, $description, $date);

header('location: ' . 'http://energy.org/intranet/Behandelplan.php', true);