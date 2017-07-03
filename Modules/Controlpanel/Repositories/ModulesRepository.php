<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 07/03/2017
 * Time: 02:39 PM
 */

namespace Modules\Controlpanel\Repositories;


use Caffeinated\Modules\Modules;
use Modules\Core\Repositories\FilesRepository;

class ModulesRepository
{
    /**
     * @var Modules
     */
    private $modules;
    /**
     * @var FilesRepository
     */
    private $filesRepository;
    /**
     * @var Utility
     */
    private $utility;

    /**
     * ModulesRepository constructor.
     * @param Modules $modules
     * @param Utility $utility
     */
    public function __construct(Modules $modules, Utility $utility)
    {
        $this->modules = $modules;
        $this->utility = $utility;
    }

    public function fetchModules()
    {
        $modules = $this->modules->all();

        return $modules->sortBy('refId')->all();
    }

    public function installModule()
    {
        $moduleName = $this->utility->uploadModule(request()->file('module'));

        $this->runModuleMigrations($moduleName);
    }

    public function runModuleMigrations($moduleSlug)
    {
        \Artisan::call('module:optimize');

        \Artisan::call('module:migrate', [
            'slug' => $moduleSlug,
        ]);

        \Artisan::call('module:seed', [
            'slug' => $moduleSlug,
        ]);
    }

}