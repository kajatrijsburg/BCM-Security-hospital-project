<?php
class Permissions{
    public static $manageRoles = "manageRoles";
    public static $managePermissions = "managePermissions";
    public static $manageTreatmentPlan = "manageTreatmentPlan";
    public static $manageAppointments = "manageAppointments";
    public static $manageMedication = "manageMedication";
}

function requirePermission($session, $permission){
    if (empty($session["PERMISSIONS"][$permission])){
        header('location: ' . 'http://energy.org/', true);
        die("access denied");
    }
}
function hasPermission($session, $permission){
    return !empty($session["PERMISSIONS"][$permission]);
}