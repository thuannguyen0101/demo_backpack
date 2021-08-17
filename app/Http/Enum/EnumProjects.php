<?php

namespace App\Http\Enum;

class EnumProjects
{
    /* Filter system select */
    const TYPE_PROJECTS = ['systems' => 'Systems', 'requirements' => 'Requirements', 'subFunctions' => 'Sub functions'];
    /* Filter select */
    const SYSTEMS = 'systems';
    const REQUIREMENTS = 'requirements';
    const SUBFUNCTIONS = 'subFunctions';
    /* Filter priority */
    const PRIORITY = ['high' => 'High', 'medium' => 'Medium', 'low' => 'Low'];
    /* Priority */
    const HIGH = 'high';
    const MEDIUM = 'medium';
    const LOW = 'low';
    /* Total Records */
    const NULLCOST = 0;
    /* All History */
    const ALLHISTORY = "allhistory";
}
