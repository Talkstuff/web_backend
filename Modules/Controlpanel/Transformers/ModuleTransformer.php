<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 07/03/2017
 * Time: 02:57 PM
 */

namespace Modules\Controlpanel\Transformers;


use League\Fractal\TransformerAbstract;

class ModuleTransformer extends TransformerAbstract
{
    public function transform($module)
    {
        $config = \Module::getManifest($module['slug']);
        return [
            'name' => $module['name'],
            'description' => $module['description'],
            'enabled' => (boolean) $module['enabled'],
            'permissions' => isset($config['permissions']) ? $config['permissions'] : []
        ];
    }

}